<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Exclude users with 'superadmin' user_type from listing
        $query->where('user_type', '!=', 'superadmin');

        if ($q = $request->query('q')) {
            $query->where(function ($s) use ($q) {
                $s->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }

        if ($contact = $request->query('contact')) {
            $query->where('contact', 'like', "%{$contact}%");
        }

        if ($type = $request->query('user_type')) {
            $query->where('user_type', $type);
        }

        if (! is_null($request->query('status'))) {
            $status = $request->boolean('status');
            $query->where('status', $status);
        }

        // joining date range filtering support
        $start = null;
        $end = null;
        $rangeInput = $request->query('date_range');
        if ($rangeInput) {
            $r = trim($rangeInput);
            if (preg_match('/\d{4}-\d{2}-\d{2}\s*-\s*\d{4}-\d{2}-\d{2}/', $r) || preg_match('/\d{1,2}\/\d{1,2}\/\d{4}\s*-\s*\d{1,2}\/\d{1,2}\/\d{4}/', $r)) {
                $parts = preg_split('/\s*-\s*/', $r, 2);
                if (count($parts) === 2) {
                    try {
                        $a = \Carbon\Carbon::parse($parts[0]);
                        $b = \Carbon\Carbon::parse($parts[1]);
                        $start = $a->copy()->startOfDay();
                        $end = $b->copy()->endOfDay();
                    } catch (\Exception $e) {
                        $start = null;
                        $end = null;
                    }
                }
            }
        } elseif ($joining = $request->query('joining_date')) {
            try {
                $d = \Carbon\Carbon::parse($joining);
                $start = $d->copy()->startOfDay();
                $end = $d->copy()->endOfDay();
            } catch (\Exception $e) {
                $start = null;
                $end = null;
            }
        }

        if ($start && $end) {
            $query->whereBetween('joining_date', [$start->toDateString(), $end->toDateString()]);
        }

        // pagination size control
        $perPageInput = $request->query('per_page');
        $defaultPerPage = 25;
        if ($perPageInput === 'all') {
            $users = $query->orderBy('name')->get();
        } else {
            $perPage = is_numeric($perPageInput) ? (int) $perPageInput : $defaultPerPage;
            $allowed = [$defaultPerPage, 100, 500, 1000, 5000];
            if (! in_array($perPage, $allowed)) {
                $perPage = $defaultPerPage;
            }
            $users = $query->orderBy('name')->paginate($perPage)->appends($request->query());
        }

        $usersTotal = method_exists($users, 'total') ? $users->total() : $users->count();

        return view('users.index', compact('users', 'start', 'end', 'usersTotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        return view('users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->validated());

        $request->session()->flash('user.id', $user->id);

        if ($request->has('is_plot_or_flat_owner')) {
            return redirect()->route('owners.create');
        }

        return redirect()->route('users.index')->with('success', 'User registered successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        return view('users.show', compact('user'));
    }

    /**
     * Display the specified resource.
     */
    public function profile()
    {
        $user = auth()->user();
        $owner = null;

        if ($user->user_type === 'owner' && class_exists(\App\Models\Owner::class)) {
            $owner = \App\Models\Owner::where('user_id', $user->id)->first();
        }

        return view('users.profile', compact('user', 'owner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $auth = auth()->user();
        $siteModules = config('sitemodules', []); // master list of modules/actions

        // Determine if current user can edit permissions for the target user
        $canEditPermissions = false;
        if ($auth->user_type === 'superadmin') {
            $canEditPermissions = true;
        } elseif ($auth->user_type === 'admin') {
            // Admins may only change permissions for staff users
            $canEditPermissions = ($user->user_type === 'staff');

            // Admins should not see system-level modules
            if ($canEditPermissions && isset($siteModules['system'])) {
                unset($siteModules['system']);
            }
        }

        $userPermissions = $user->permissions ?? [];

        return view('users.edit', compact('user', 'siteModules', 'userPermissions', 'canEditPermissions'))->with('mode', 'edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $validatedData = $request->validated();

        $auth = auth()->user();

        // Enforce permission editing rules server-side
        if (array_key_exists('permissions', $validatedData)) {
            if ($auth->user_type === 'admin') {
                // Admins can only modify staff users' permissions and not their own
                if ($user->user_type !== 'staff' || $auth->id === $user->id) {
                    abort(403, 'Unauthorized to modify permissions for this user.');
                }
            } elseif ($auth->user_type !== 'superadmin') {
                // Only superadmin and admin may submit permission changes
                abort(403, 'Unauthorized to modify permissions.');
            }
        }

        if (! empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        // Persist permissions as JSON on user (if provided) - sanitize against site modules
        if (array_key_exists('permissions', $validatedData)) {
            $siteModules = config('sitemodules', []);
            // If the actor is admin, ensure system modules are not considered
            if ($auth->user_type === 'admin' && isset($siteModules['system'])) {
                unset($siteModules['system']);
            }
            $roleDefaults = config('permissions.' . $user->user_type, []);
            $sanitized = [];

            foreach ($validatedData['permissions'] as $module => $actions) {
                if (! isset($siteModules[$module])) {
                    continue;
                }

                $allowed = (array) $siteModules[$module];
                $inputActions = (array) $actions;
                $roleActions = (array) ($roleDefaults[$module] ?? []);

                // Effective actions: union of input and role defaults, restricted to allowed actions
                $effective = array_values(array_intersect($allowed, array_values(array_unique(array_merge($inputActions, $roleActions)))));

                // Add paired actions based on effective permissions (create->store, edit->update)
                if (in_array('create', $effective) && in_array('store', $allowed) && ! in_array('store', $effective)) {
                    $effective[] = 'store';
                }
                if (in_array('edit', $effective) && in_array('update', $allowed) && ! in_array('update', $effective)) {
                    $effective[] = 'update';
                }

                $effective = array_values(array_unique(array_intersect($allowed, $effective)));

                // Persist only actions that are NOT already provided by role defaults
                $toPersist = array_values(array_diff($effective, $roleActions));

                if (! empty($toPersist)) {
                    $sanitized[$module] = $toPersist;
                }
            }

            $user->permissions = $sanitized ?: null;
        }

        $user->update($validatedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }

    public function uploadProfileImage(Request $request): JsonResponse
    {
        $user = auth()->user();

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:100',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $imagePath = $image->store('profile_images', 'public');

            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->profile_photo = $imagePath;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully!',
                'imageUrl' => Storage::url($imagePath),
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Image upload failed. Please try again.',
        ], 422);
    }
}
