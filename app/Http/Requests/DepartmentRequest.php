<?php

namespace App\Http\Requests;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function rules()
    {
        $department = $this->route('department') ?? new Department();
        return [
            "name"=>["required","string"],
            "short_cut"=>["required","string",'unique:departments,short_cut,' . $department->id],
        ];
    }
}
