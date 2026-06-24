<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:191', 'unique:clients,email'],
            'nid_passport' => ['nullable', 'string', 'max:191', 'unique:clients,nid_passport'],
            'address' => ['nullable', 'string'],
        ];
    }
}
