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
        $departmentCause=DepartmentCause::create($request->all());
        return $this->returnData($departmentCause);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DepartmentCause  $departmentCause
     * @return \Illuminate\Http\Response
     */
    public function destroy(DepartmentCause $departmentCause)
    {
        $departmentCause->delete();
        return $this->returnSuccessMessage('Cause deleted successfully');
    }
}
