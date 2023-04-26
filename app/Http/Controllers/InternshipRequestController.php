<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\SendEmail;
use App\Models\Department;
use App\Models\CompanyCause;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\CompanyRefuse;
use App\Models\StudentAccount;
use App\Models\DepartmentCause;
use Illuminate\Validation\Rule;
use App\Models\DepartmentRefuse;
use App\Models\InternshipRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\InternshipResponsible;
use App\Services\DepartmentHeadService;
use Illuminate\Support\Facades\Validator;
use App\Services\InternshipResponsibleService;
use App\Http\Requests\InternshipRequest_Request;
use App\Http\Resources\InternshipRequestResource;


class InternshipRequestController extends Controller
{
    public $decisions = ['accept', 'refuse', 'refuse_definitively'];
    use GeneralTrait, SendEmail;
    public function index()
    {
        // todo the auth sould be departemnt head or interndhip respo
        if (Auth::getDefaultDriver() == config('global.department_head_guard')) {
            $internshipRequests = Department::find(auth()->user()->department_id)->studentsIntershipRequests;
        } else {
            $internshipRequests = InternshipResponsible::find(2)->studentsIntershipRequests();
        }
        return $this->returnData(InternshipRequestResource::collection($internshipRequests));
    }


    public function store(InternshipRequest_Request $request, CompanyController $companyController)
    {
        // TODO only student
        // TODO check if this request came with a hidden input called ...
        // this last showing if the request is in refused tables(compnay/Departement) to ne deleted form the table 

        $company = $companyController->findOrCreate($request->company_name, $request->company_location);

        $internshipRequest = InternshipRequest::create($request->validated() + ['company_id' => $company->id]);
        return $this->returnData(new InternshipRequestResource($internshipRequest));
    }


    public function show(InternshipRequest $internshipRequest)
    {
        if (Auth::getDefaultDriver() == config('global.internship_responsible_guard')) {

            $authorized_ids = InternshipResponsible::find(auth()->id())->studentsIntershipRequestsId();
            abort_if(!in_array($internshipRequest->id, $authorized_ids), 403);
        } else if (Auth::getDefaultDriver() == config('global.department_head_guard')) {
            $authorized_ids = Department::find(auth()->user()->department_id)->studentsIntershipRequestsId();
            abort_if(!in_array($internshipRequest->id, $authorized_ids), 403);
        } else {
            // student part
            return 3;
        }
        return $this->returnData(new InternshipRequestResource($internshipRequest));
    }

    public function update(InternshipRequest_Request $request, InternshipRequest $internshipRequest, CompanyController $companyController)
    {
        //    TDOO authorization same as show

        $company = $companyController->findOrCreate($request->company_name, $request->company_location);

        $internshipRequest->update($request->validated() + ['company_id' => $company->id]);
        return $this->returnData(new InternshipRequestResource($internshipRequest));
    }

    public function destroy(InternshipRequest $internshipRequest)
    {
        //    TDOO authorization same as show
        $internshipRequest->delete();
        return $this->returnSuccessMessage('Request deleted successfully');
    }



    public function manageTheInternshipRequest(Request $request, InternshipRequest $internshipRequest)
    {
        //TDOO authorization same as show but without student part
        try {
            // TODO fix this header by testing auth guard
            Validator::make($request->all(), [
                'decision' => ['required',  Rule::in($this->decisions)]
            ])->validate();

            if (Auth::getDefaultDriver() == 'internship_responsible') {
                return $this->manageTheInternshipRequest_InternshipResponsible($request, $internshipRequest);

            } elseif (Auth::getDefaultDriver() == 'department_head') {
                return $this->manageTheInternshipRequest_DepartmentHead($request, $internshipRequest);
            }
            
            abort(401);
        } catch (\Exception $ex) {
            return $this->returnError($ex->getMessage());
        }
    }
    public function manageTheInternshipRequest_DepartmentHead(Request $request, InternshipRequest $internshipRequest)
    {
        // if dicition true
        // create account for respo
        // notification to respo

        // if dicition refuse diff
        // notification to student
        // delete request


        // if dicition refuse 
        // get a couse 
        // notification to student
        // insert to refuses table
        $departmentHeadService=new DepartmentHeadService;
        switch ($request->decision) {
            case "accept":
                return  $departmentHeadService->acceptTheInternshipRequest_DepartmentHead($request, $internshipRequest,new InternshipResponsibleService);
                break;

            case "refuse":
                $request->validate([
                    'cause_id' => ['required', 'exists:department_causes,id']
                ]);
                return  $departmentHeadService->refuseTheInternshipRequest_DepartmentHead($request, $internshipRequest);
                break;

            case "refuse_definitively":
                $request->validate([
                    'cause_id' => ['required', 'exists:department_causes,id']
                ]);
                return  $departmentHeadService->refuse_definitivelyTheInternshipRequest_DepartmentHead($request, $internshipRequest);
                break;
        }
    }




    public function manageTheInternshipRequest_InternshipResponsible(Request $request, InternshipRequest $internshipRequest)
    {



        //if dicition true
        // status is 1
        // notification to student


        // if dicition false 
        // get a couse 
        // notification to student
        // insert to refuses table

        // if dicition false diff
        // notification to student
        // deleted


        $internshipResponsibleService=new InternshipResponsibleService; 

        switch ($request->decision) {
            case "accept":
                return $internshipResponsibleService->acceptTheInternshipRequest_InternshipResponsible($internshipRequest);
                break;
            case "refuse":
                Validator::make($request->all(), [
                    'cause_id' => ['required', 'exists:company_causes,id']
                ])->validate();
                return  $internshipResponsibleService->refuseTheInternshipRequest_InternshipResponsible($request, $internshipRequest);

                break;
            case "refuse_definitively":
                Validator::make($request->all(), [
                    'cause_id' => ['required', 'exists:company_causes,id']
                ])->validate();

                return  $internshipResponsibleService->refuse_definitivelyTheInternshipRequest_InternshipResponsible($request, $internshipRequest);
                break;
        }
    }

    public function studentInternships()
    {
        // todo the auth sould be interndhip respo
        if (Auth::getDefaultDriver() == config('global.internship_responsible_guard')) {
            $internshipRequests = InternshipResponsible::find(auth()->id())->studentsInterships();
        }
        return $this->returnData(InternshipRequestResource::collection($internshipRequests));
    }
    public function studentInternshipsNotAssessedToday()
    {
        // todo the auth sould be interndhip respo
        if (Auth::getDefaultDriver() == config('global.internship_responsible_guard')) {
            $internshipRequests = InternshipResponsible::find(auth()->id())->notAssessedStudentToday();
            return $this->returnData(InternshipRequestResource::collection($internshipRequests));
        }
        abort(403);
    }
}
