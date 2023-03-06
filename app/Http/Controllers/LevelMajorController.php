<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\LevelMajor;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
class LevelMajorController extends Controller
{
 
    public function index()
    {
        
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LevelMajor  $levelMajor
     * @return \Illuminate\Http\Response
     */
    public function show(LevelMajor $levelMajor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LevelMajor  $levelMajor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LevelMajor $levelMajor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LevelMajor  $levelMajor
     * @return \Illuminate\Http\Response
     */
    public function destroy(LevelMajor $levelMajor)
    {
        //
    }
}
