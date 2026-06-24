<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('department')?->id ?? null;
        return [
            'name' => ['required','string','max:191','unique:departments,name'.($id?','.$id:'' )],
            'remarks' => ['nullable','string'],
        ];
    }
}
