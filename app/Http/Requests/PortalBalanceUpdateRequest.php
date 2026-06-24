<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortalBalanceUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return (new PortalBalanceStoreRequest())->rules();
    }
}
