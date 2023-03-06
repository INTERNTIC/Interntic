<?php

namespace App\Http\Controllers;

use App\Models\CompanyCause;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanyCauseController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->returnData(CompanyCause::all());
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
        $companyCause=CompanyCause::create($request->all());
        return $this->returnData($companyCause);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompanyCause  $companyCause
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyCause $companyCause)
    {
        $companyCause->delete();
        return $this->returnSuccessMessage('Cause deleted successfully');
    }
}
