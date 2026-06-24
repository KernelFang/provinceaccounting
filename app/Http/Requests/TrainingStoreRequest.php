<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'training_type' => ['nullable','string','max:191'],
            'title' => ['nullable','string','max:191'],
            'customer_name' => ['nullable','string','max:191'],
            'customer_number' => ['nullable','string','max:50'],
            'package' => ['nullable','string','max:191'],
            'description' => ['nullable','string','max:1000'],
            'agent_cost' => ['nullable','numeric'],
            'customer_price' => ['nullable','numeric'],
            'customer_payment' => ['nullable','numeric'],
            'customer_due' => ['nullable','numeric'],
            'profit' => ['nullable','numeric'],
            'purchase_date' => ['nullable','date'],
        ];
    }
}
