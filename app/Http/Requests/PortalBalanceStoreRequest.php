<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortalBalanceStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaction_type' => ['required', 'string', 'in:credit,debit'],
            'info' => ['required', 'string', 'exists:infos,name'],
            'date' => ['nullable', 'date'],
            'portal' => ['required', 'string', 'exists:portals,name'],
            'recharge' => ['nullable', 'numeric', 'regex:/^\d{1,10}(\.\d{1,2})?$/', 'min:0'],
            'sender' => ['nullable', 'string', 'max:191'],
            'reference' => ['nullable', 'string', 'max:255'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
