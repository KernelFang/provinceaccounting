<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'code_identifier' => ['required', 'string', 'max:191', 'unique:payment_methods,code_identifier'],
            'type' => ['required', 'in:Cash,Bank,Mobile Banking,Gateway'],
            'account_details' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
