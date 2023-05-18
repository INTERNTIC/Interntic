<?php

namespace App\Http\Requests;

use App\Models\DepartmentHead;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DepartmentHeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $department_head = $this->route('departmentHead') ?? new DepartmentHead();
        // Password is not required if this is an update
        return[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>['required','email','ends_with:univ-constantine2.dz','unique:department_heads,email,'.$department_head->id],
            'password' => [Rule::requiredIf(!$department_head->id), 'min:6'],
            'department_id' => ['required', 'exists:departments,id'],

        ];
    }
}
