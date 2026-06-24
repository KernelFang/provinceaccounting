<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class SoftDeleteController extends Controller
{
    public function restore(string $resource, $id)
    {
        $modelClass = $this->resolveModelClass($resource);
        $model = $modelClass::withTrashed()->findOrFail($id);
        $model->restore();

        return redirect()->back()->with('success', class_basename($model).' restored successfully.');
    }

    public function forceDelete(string $resource, $id)
    {
        $modelClass = $this->resolveModelClass($resource);
        $model = $modelClass::withTrashed()->findOrFail($id);
        $model->forceDelete();

        return redirect()->back()->with('success', class_basename($model).' permanently deleted.');
    }

    protected function resolveModelClass(string $resource): string
    {
        // Convert route prefix like `portal-balances` -> `PortalBalance`
        $name = str_replace('-', '_', $resource);
        $name = Str::singular($name);
        $candidate = 'App\\Models\\'.Str::studly($name);

        if (class_exists($candidate)) {
            return $candidate;
        }

        abort(404, "Model for resource [$resource] not found.");
    }
}
