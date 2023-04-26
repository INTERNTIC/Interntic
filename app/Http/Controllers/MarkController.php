<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Traits\GeneralTrait;
use App\Http\Requests\MarkRequest;
use App\Http\Resources\MarkResource;
use Illuminate\Support\Facades\Auth;
use App\Models\InternshipResponsible;

class MarkController extends Controller
{
    // TODO fix authorizetion
    use GeneralTrait;
    public function index()
    {
        // todo the auth sould be  interndhip respo
        if (Auth::getDefaultDriver() == config('global.internship_responsible_guard')) {
            $marks = InternshipResponsible::find(auth()->id())->studentsMark();
        }
        return $this->returnData(MarkResource::collection($marks));
    }

    public function store(MarkRequest $request)
    {
        //validate responsible his requests 
        if (Auth::getDefaultDriver() == config('global.internship_responsible_guard')) {
            $authorized_ids = InternshipResponsible::find(auth()->id())->studentsIntershipIds();
            if (in_array($request->internship_request_id, $authorized_ids)) {
                $mark = Mark::create($request->validated());
                return $this->returnData(new MarkResource($mark),"Saved Successfully");
            }
        }
        abort(403);

    }

    public function show(Mark $mark)
    {
        return $this->returnData(new MarkResource($mark));
    }

    public function update(MarkRequest $request, Mark $mark)
    {
        if (Auth::getDefaultDriver() == config('global.internship_responsible_guard')) {
            $authorized_ids = InternshipResponsible::find(auth()->id())->studentsIntershipIds();
            if (in_array($request->internship_request_id, $authorized_ids)) {
                $mark->update($request->validated());
                return $this->returnData(new MarkResource($mark),"update Successfully");
            }
        }
        abort(403);
    }


    public function destroy(Mark $mark)
    {
        if ($mark->delete()) {
            return $this->returnSuccessMessage("Deleted Succssfully");
        }
    }
}
