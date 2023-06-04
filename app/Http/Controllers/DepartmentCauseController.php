<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentCauseResource;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\DepartmentCause;
use Illuminate\Support\Facades\Validator;

class DepartmentCauseController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        // return $this->returnData(DepartmentCause::all());
        $department_causes=DepartmentCause::where("department_id",auth()->id())->paginate(4);
        return DepartmentCauseResource::collection($department_causes);
    }
    public function get_all()
    {
        return $this->returnData(DepartmentCauseResource::collection(DepartmentCause::where("department_id",auth()->id())->get()));
    }

    public function store(Request $request)
    {
        $request->validate([ 
            'cause'=>['required','string'],
        ]);
        $department_id=auth()->id();
        $departmentCause=DepartmentCause::create($request->only('cause')+['department_id'=>$department_id]);
        return $this->returnData($departmentCause);
    }
    public function update(Request $request, DepartmentCause $departmentCause)
    {
        $request->validate([ 
            'cause'=>['required','string'],
        ]);
        $departmentCause->update($request->only("cause"));
        return $this->returnData($departmentCause,"Updated Succssefuly");
    }

    public function destroy(DepartmentCause $departmentCause)
    {
        $departmentCause->delete();
        return $this->returnSuccessMessage('Cause deleted successfully');
    }
}
