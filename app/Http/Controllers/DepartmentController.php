<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Traits\GeneralTrait;
use App\Http\Requests\DepartmentRequest;

class DepartmentController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        return $this->returnData(Department::all());
    }

    public function store(DepartmentRequest $request)
    {
        $department = Department::create($request->validated());
        return $this->returnData($department);
    }
    public function show(Department $department)
    {
        return $this->returnData($department);
    }

    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->validated());
        return $this->returnData($department);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return $this->returnSuccessMessage('Department deleted successfully');
    }
}
