<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['nullable', 'email', Rule::unique('users', 'email')->ignore($this->route('user')->id)],
            'username' => ['nullable', 'string', 'unique:users,username'],
            'user_type' => ['nullable', 'in:admin,staff'],
            'gender' => ['nullable', 'in:male,female,other'],
            'address' => ['nullable', 'string'],
            'joining_date' => ['nullable', 'date'],
            'contact' => ['nullable', 'string'],
            'date_of_birth' => ['nullable', 'date'],
            'about_me' => ['nullable', 'string', 'max:600'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
               'permissions' => ['nullable', 'array'],
            // 'profile_photo' => ['nullable', 'string'],
        ];
    }

    /**
     * Configure the validator instance to ensure permissions match site modules.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $siteModules = config('sitemodules', []);
            $perms = $this->input('permissions', []);

            if (!is_array($perms)) return;

            foreach ($perms as $module => $actions) {
                if (!isset($siteModules[$module])) {
                    $validator->errors()->add('permissions', "Invalid module: {$module}");
                    continue;
                }

                if (!is_array($actions)) {
                    $validator->errors()->add('permissions', "Invalid actions for module: {$module}");
                    continue;
                }

                $allowed = (array) $siteModules[$module];
                foreach ($actions as $a) {
                    if (!in_array($a, $allowed)) {
                        $validator->errors()->add('permissions', "Invalid action '{$a}' for module: {$module}");
                    }
                }
            }
        });
    }
}
