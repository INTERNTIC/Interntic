<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use App\Models\InternshipResponsible;
use App\Http\Requests\AssessmentRequest;
use App\Http\Resources\AssessmentResource;
use App\Http\Resources\InternshipRequestResource;

class AssessmentController extends Controller
{
    // TODO all assessment should be for internship are accepted
    use GeneralTrait;
    public function index()
    {
        // internship respo
        if (Auth::getDefaultDriver() == config('global.internship_responsible_guard')) {
            $authorizedInternshipsIds = InternshipResponsible::find(auth()->id())->internshipsIAcceptedByStudentId();
            $assessments=Assessment::allAssessments($authorizedInternshipsIds);
            return $this->returnData(AssessmentResource::collection($assessments));     
        }
    }
  

    public function store(AssessmentRequest $request)
    {
        $assessment = Assessment::create($request->validated());
        return $this->returnData(new AssessmentResource($assessment),"Done");
    }


    public function show(Assessment $assessment)
    {
        return $this->returnData(new AssessmentResource($assessment));
    }


    public function update(AssessmentRequest $request, Assessment $assessment)
    {
        $assessment->update($request->validated());
        return $this->returnData(new AssessmentResource($assessment),"updated successfully");
    }
    public function destroy(Assessment $assessment)
    {
        $assessment->delete();
        return $this->returnSuccessMessage('Aseessment deleted successfully');
    }
    // public function assessmentsOfInternship($internship_request_id)
    // {
    // TODO check authorization
    //     $assessments = Assessment::where('internship_request_id', $internship_request_id)->get();
      
    //     return $this->returnData(AssessmentResource::collection($assessments));
    // }
}
