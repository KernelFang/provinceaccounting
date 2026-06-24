<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncomeUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $incomeId = $this->route('income')?->id;

        return [
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'flat_id' => ['required', 'integer', 'exists:flats,id'],
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'payment_method_id' => ['required', 'integer', 'exists:payment_methods,id'],
            'purpose' => ['nullable', 'string', 'max:191'],
            'price' => ['required', 'numeric', 'min:0'],
            'invoice_no' => ['required', 'string', 'max:191', 'unique:incomes,invoice_no,' . $incomeId],
            'clearing_status' => ['required', 'in:pending,cleared,bounced'],
            'remarks' => ['nullable', 'string'],
        ];
    }
}
