<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseTypeUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $expenseTypeId = $this->route('expense_type')?->id;

        return [
            'name' => ['required', 'string', 'max:191', 'unique:expense_types,name,' . $expenseTypeId],
            'description' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
