<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlatPricingHistoryStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'flat_id' => ['required', 'integer', 'exists:flats,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'effective_date' => ['required', 'date'],
            'changed_by' => ['nullable', 'integer', 'exists:users,id'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
