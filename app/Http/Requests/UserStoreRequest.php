<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UserStoreRequest extends FormRequest
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
            'email' => ['nullable', 'email', 'unique:users,email'],
            'username' => ['nullable', 'string', 'unique:users,username'],
            'user_type' => ['nullable', 'in:admin,staff'],
            'gender' => ['nullable', 'in:male,female,other'],
            'address' => ['nullable', 'string'],
            'joining_date' => ['nullable', 'date'],
            'contact' => ['nullable', 'string'],
            'date_of_birth' => ['nullable', 'date'],
            'about_me' => ['nullable', 'string', 'max:600'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            // 'profile_photo' => ['nullable', 'string'],
            'is_plot_or_flat_owner' => ['sometimes', 'accepted'],
        ];
    }
}
