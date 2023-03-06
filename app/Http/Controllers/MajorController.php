<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MajorController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->returnData(Major::all());
        
    }
    public function store(Request $request)
    {
        Validator::make($request->all(),[ 
            'name'=>['required','string'],
            'short_cut'=>['required','string','unique:majors'],
        ])->validate();
        $major=Major::create($request->all());
        return $this->returnData($major);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function show(Major $major)
    {
        return $this->returnData($major);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Major $major)
    {
        Validator::make($request->all(),[ 
            'name'=>['required','string'],
            'short_cut'=>['required','string','unique:majors,short_cut,'.$major->id],
        ])->validate();
        $major->update($request->all());
        return $this->returnData($major);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Major  $major
     * @return \Illuminate\Http\Response
     */
    public function destroy(Major $major)
    {
        $major->delete();
        return $this->returnSuccessMessage('Major deleted successfully');
    }
}
