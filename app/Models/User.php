<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'gender',
        'address',
        'user_type',
        'password',
        'contact',
        'date_of_birth',
        'joining_date',
        'profile_photo',
        'about_me',
        'permissions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'address_id' => 'integer',
        'date_of_birth' => 'date',
        'joining_date' => 'date',
        'permissions' => 'array',
    ];

    /**
     * Return merged permissions (role defaults + user specific)
     *
     * @return array
     */
    public function mergedPermissions(): array
    {
        $role = $this->user_type ?? null;
        $rolePermissions = config("permissions.{$role}", []);
        $userPermissions = $this->permissions ?? [];

        $siteModules = config('sitemodules', []);

        $merged = [];

        // start with role defaults but only include allowed actions
        foreach ($rolePermissions as $module => $actions) {
            if (!isset($siteModules[$module])) continue;

            if (is_array($actions) && in_array('*', $actions)) {
                $merged[$module] = ['*'];
                continue;
            }

            $allowed = (array) $siteModules[$module];
            $filtered = array_values(array_intersect((array) $actions, $allowed));
            $merged[$module] = $filtered;
        }

        // merge user specific permissions (grant additional actions)
        foreach ($userPermissions as $module => $actions) {
            if (!isset($siteModules[$module])) continue;

            // if wildcard, set wildcard
            if (is_array($actions) && in_array('*', $actions)) {
                $merged[$module] = ['*'];
                continue;
            }

            $allowed = (array) $siteModules[$module];
            $filtered = array_values(array_intersect((array) $actions, $allowed));

            if (!isset($merged[$module]) || $merged[$module] === ['*']) {
                $merged[$module] = $filtered;
            } else {
                $merged[$module] = array_values(array_unique(array_merge($merged[$module], $filtered)));
            }
        }

        // remove empty modules
        foreach ($merged as $m => $acts) {
            if (empty($acts)) unset($merged[$m]);
        }

        // Couple actions: if 'create' granted also ensure 'store' is present; if 'edit' granted ensure 'update' present
        foreach ($merged as $m => $acts) {
            if ($acts === ['*']) continue;
            $allowed = (array) ($siteModules[$m] ?? []);

            if (in_array('create', $acts) && in_array('store', $allowed) && !in_array('store', $acts)) {
                $merged[$m][] = 'store';
            }

            if (in_array('edit', $acts) && in_array('update', $allowed) && !in_array('update', $acts)) {
                $merged[$m][] = 'update';
            }

            // normalize unique ordering
            $merged[$m] = array_values(array_unique($merged[$m]));
        }

        return $merged;
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
