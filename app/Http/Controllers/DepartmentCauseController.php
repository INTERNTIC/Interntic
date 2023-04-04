<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\DepartmentCause;
use Illuminate\Support\Facades\Validator;

class DepartmentCauseController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->returnData(DepartmentCause::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(),[ 
            'cause'=>['required','string'],
        ])->validate();
        $department_id=auth()->id();
        $departmentCause=DepartmentCause::create($request->only('cause')+['department_id'=>$department_id]);
        return $this->returnData($departmentCause);
    }

    public function destroy(DepartmentCause $departmentCause)
    {
        $departmentCause->delete();
        return $this->returnSuccessMessage('Cause deleted successfully');
    }
}
