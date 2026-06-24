<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlatStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'building_no' => ['nullable', 'string', 'max:50'],
            'floor_no' => ['nullable', 'string', 'max:50'],
            'flat_no' => ['nullable', 'string', 'max:50'],
            'total_flat_area_sqft' => ['nullable', 'numeric', 'min:0'],
            'cost_per_sqft' => ['nullable', 'numeric', 'min:0'],
            'base_price' => ['nullable', 'numeric', 'min:0'],
            'is_reselled' => ['sometimes', 'boolean'],
            'client_owner_status' => ['required', 'in:pending,ongoing,cancelled,completed'],
            'current_owner_id' => ['nullable', 'integer', 'exists:clients,id'],
        ];
    }
}
