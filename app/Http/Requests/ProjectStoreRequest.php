<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'location' => ['required', 'string', 'max:191'],
            'status' => ['required', 'in:pending,ongoing,cancelled,completed'],
        ];
    }
}
