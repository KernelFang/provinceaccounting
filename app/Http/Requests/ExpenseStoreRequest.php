<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if the user is authenticated and has the necessary role (admin or staff)
        // return auth()->check() && in_array(auth()->user()->user_type, ['admin', 'staff']);

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
            'title' => ['required', 'string', 'max:191'],
            'project_id' => ['nullable', 'integer', 'exists:projects,id'],
            'expense_type_id' => ['required', 'integer', 'exists:expense_types,id'],
            'flat_id' => ['nullable', 'integer', 'exists:flats,id'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
            'date' => ['required', 'date'],
            'expense_details' => ['nullable', 'string'],
            'amount' => ['required', 'numeric', 'min:0'],
            'transaction_reference' => ['required', 'string', 'max:191'],
            'payment_status' => ['required', 'in:paid,unpaid,petty_cash'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'title' => 'Expense Title',
            'amount' => 'Expense Amount',
            'date' => 'Expense Date',
            'category' => 'Expense Category',
            'payment_status' => 'Payment Status',
            'description' => 'Expense Description',
        ];
    }

    /**
     * Get the custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'date.before_or_equal' => 'The expense date cannot be in the future.',
            'amount.min' => 'The amount must be greater than zero.',
            'payment_status.in' => 'Payment status must be one of: paid, unpaid, petty_cash.',
        ];
    }
}
