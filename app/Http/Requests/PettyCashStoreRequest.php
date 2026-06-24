<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PettyCashStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'transaction_type' => ['required', 'in:credit_manual,debit_expense'],
            'amount' => ['required', 'numeric', 'regex:/^\d{1,14}(\.\d{1,2})?$/', 'min:0'],
            'current_balance' => ['required', 'numeric'],
            'expense_id' => ['nullable', 'integer', 'exists:expenses,id'],
            'date' => ['required', 'date', 'before_or_equal:today'],
            'description' => ['nullable', 'string', 'max:400'],
        ];
    }
}
