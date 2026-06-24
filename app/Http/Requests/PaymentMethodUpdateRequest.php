<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $paymentMethodId = $this->route('payment_method')?->id;

        return [
            'name' => ['required', 'string', 'max:191'],
            'code_identifier' => ['required', 'string', 'max:191', 'unique:payment_methods,code_identifier,' . $paymentMethodId],
            'type' => ['required', 'in:Cash,Bank,Mobile Banking,Gateway'],
            'account_details' => ['nullable', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
