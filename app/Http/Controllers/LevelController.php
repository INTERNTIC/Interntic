<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\GeneralTrait;
class LevelController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->returnData(Level::all());
        
    }



 
    public function store(Request $request)
    {
        Validator::make($request->all(),[ 
            'name'=>['required','string','unique:levels'],
        ])->validate();
        $level=Level::create($request->all());
        return $this->returnData($level);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show(Level $level)
    {
        return $this->returnData($level);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Level $level)
    {
        Validator::make($request->all(),[ 
            'name'=>['required','string','unique:levels'],
        ])->validate();
        $level->update($request->all());
        return $this->returnData($level);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level)
    {
        $level->delete();
        return $this->returnSuccessMessage('Level deleted successfully');
    }
    public function getMajors(Level $level)
    {
        return $this->returnData($level->majors);
    }
}
