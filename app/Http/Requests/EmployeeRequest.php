<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('employee')?->id ?? null;
        return [
            'employee_code' => ['required','string','max:191','unique:employees,employee_code'.($id?','.$id:'' )],
            'name' => ['required','string','max:191'],
            'email' => ['nullable','email','max:191','unique:employees,email'.($id?','.$id:'' )],
            'phone' => ['nullable','string','max:50'],
            'nid' => ['nullable','string','max:100'],
            'dob' => ['nullable','date'],
            'joining_date' => ['nullable','date'],
            'exit_date' => ['nullable','date','after_or_equal:joining_date'],
            'department_id' => ['nullable','exists:departments,id'],
            'designation_id' => ['nullable','exists:designations,id'],
            'status' => ['nullable','string'],
            'employment_type' => ['nullable','string'],
        ];
    }
}
