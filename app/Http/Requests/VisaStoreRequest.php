<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'purpose' => ['required','string','exists:visa_purposes,name'],
            'country' => ['required','string','exists:countries,name'],
            'description' => ['nullable','string','max:1000'],
            'from_date' => ['nullable','date'],
            'to_date' => ['nullable','date','after_or_equal:from_date'],
            'purchase_date' => ['nullable','date'],
            'customer' => ['nullable','string','max:191'],
            'person' => ['nullable','integer','min:1'],
            'mobile_number' => ['nullable','string','max:50'],
            'emergency_number' => ['nullable','string','max:50'],
            'agent_cost' => ['nullable','numeric'],
            'customer_price' => ['nullable','numeric'],
            'customer_payment' => ['nullable','numeric'],
            'customer_due' => ['nullable','numeric'],
            'profit' => ['nullable','numeric'],
            'status' => ['nullable','string','in:pending,inprogress,cancelled,completed,paused'],
        ];
    }
}
