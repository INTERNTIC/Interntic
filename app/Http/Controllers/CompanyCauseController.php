<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyCauseResource;
use App\Models\CompanyCause;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class CompanyCauseController extends Controller
{
    use GeneralTrait;
    public function index()
    {
        return CompanyCauseResource::collection(CompanyCause::where('company_id',auth()->id())->paginate(4));
    }
    public function get_all()
    {
        return $this->returnData(CompanyCauseResource::collection(CompanyCause::where("company_id",auth()->id())->get()));
    }

    public function store(Request $request)
    {
        $request->validate([ 
            'cause'=>['required','string'],
        ]);
        $company_id=auth()->id();
        $companyCause=CompanyCause::create($request->only('cause')+['company_id'=>$company_id]);
        return $this->returnData($companyCause);
    }

    public function update(Request $request, CompanyCause $companyCause)
    {
        $request->validate([ 
            'cause'=>['required','string'],
        ]);
        $companyCause->update($request->only("cause"));
        return $this->returnData($companyCause,"Updated Succssefuly");
    }

    public function destroy(CompanyCause $companyCause)
    {
        $companyCause->delete();
        return $this->returnSuccessMessage('Cause deleted successfully');
    }
}
