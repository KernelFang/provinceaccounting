<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesignationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('designation')?->id ?? null;
        return [
            'title' => ['required','string','max:191','unique:designations,title'.($id?','.$id:'' )],
            'remarks' => ['nullable','string'],
        ];
    }
}
