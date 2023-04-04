<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssessmentRequest;
use App\Http\Resources\AssessmentResource;
use App\Models\Assessment;
use App\Traits\GeneralTrait;

class AssessmentController extends Controller
{
    // TODO all assessment should be for internship are accepted
    use GeneralTrait;
    public function index($internship_request_id)
    {
        $assessments = Assessment::where('internship_request_id', $internship_request_id)->get();
      
        return $this->returnData(AssessmentResource::collection($assessments));
    }

    public function store(AssessmentRequest $request)
    {
        $assessment = Assessment::create($request->validated());
        return $this->returnData(new AssessmentResource($assessment));
    }


    public function show(Assessment $assessment)
    {
        return $this->returnData(new AssessmentResource($assessment));
    }


    public function update(AssessmentRequest $request, Assessment $assessment)
    {
        $assessment->update($request->validated());
        return $this->returnData(new AssessmentResource($assessment));
    }
    public function destroy(Assessment $assessment)
    {
        $assessment->delete();
        return $this->returnSuccessMessage('Aseessment deleted successfully');
    }
}
