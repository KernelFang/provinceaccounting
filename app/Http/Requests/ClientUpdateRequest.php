<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('client')?->id;

        return [
            'first_name' => ['required', 'string', 'max:191'],
            'last_name' => ['required', 'string', 'max:191'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:191', 'unique:clients,email,' . $clientId],
            'nid_passport' => ['nullable', 'string', 'max:191', 'unique:clients,nid_passport,' . $clientId],
            'address' => ['nullable', 'string'],
        ];
    }
}
