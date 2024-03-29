<?php

namespace App\Http\Controllers;

use App\Models\Student;
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
use App\Services\PDFGenerateService;
use Illuminate\Support\Facades\Auth;
use App\Models\InternshipResponsible;
use App\Services\DepartmentHeadService;
use Illuminate\Support\Facades\Validator;
use App\Services\InternshipResponsibleService;
use App\Http\Requests\InternshipRequest_Request;
use App\Http\Resources\InternshipRequestResource;
use App\Services\StudentService;

class InternshipRequestController extends Controller
{
    public $decisions = ['accept', 'refuse', 'refuse_definitively'];
    use GeneralTrait;

    public function index()
    {
        switch (Auth::getDefaultDriver()) {
            case config('global.department_head_guard'):
                $internshipRequests = Department::find(auth()->user()->department_id)->internshipsWaiting();
                break;
            case config('global.internship_responsible_guard'):
                $internshipRequests = InternshipResponsible::find(auth()->user()->id)->internshipsWaiting();
                break;
            case config('global.student_guard'):
                $internshipRequests = Student::find(auth()->user()->id)->waitingInternshipsForDepartment();
                break;

            default:
                abort(403);
                break;
        }
        return $this->returnData(InternshipRequestResource::collection($internshipRequests));
    }


    public function store(InternshipRequest_Request $request)
    {
        $isExistInternshipResponsible = InternshipResponsible::where("email", $request->internshipResponsible_email)->first();
        if ($isExistInternshipResponsible) {
            if ($isExistInternshipResponsible->company->id != $request->company_id) {
                return $this->returnError("Company You choesed is Wrong the right company is " . $isExistInternshipResponsible->company->name . " " . $isExistInternshipResponsible->company->location);
            }
        }
        $internshipRequest = InternshipRequest::create($request->validated());
        return $this->returnData(new InternshipRequestResource($internshipRequest));
    }


    public function show(InternshipRequest $internshipRequest)
    {
        switch (Auth::getDefaultDriver()) {
            case config('global.internship_responsible_guard'):
                $authorized_ids = InternshipResponsible::find(auth()->id())->studentsIntershipRequestsId();
                abort_if(!in_array($internshipRequest->id, $authorized_ids), 403);
                break;
            case config('global.department_head_guard'):
                $authorized_ids = Department::find(auth()->user()->department_id)->studentsIntershipRequestsId();
                abort_if(!in_array($internshipRequest->id, $authorized_ids), 403);
                break;
        }
        return $this->returnData(new InternshipRequestResource($internshipRequest));
    }

    public function update(InternshipRequest_Request $request, InternshipRequest $internshipRequest, CompanyController $companyController)
    {
        $isExistInternshipResponsible = InternshipResponsible::where("email", $request->internshipResponsible_email)->first();
        if ($isExistInternshipResponsible) {
            if ($isExistInternshipResponsible->company->id != $request->company_id) {
                return $this->returnError("Company You choesed is Wrong the right company is " . $isExistInternshipResponsible->company->name . " " . $isExistInternshipResponsible->company->location);
            }
        }
        //    TDOO authorization same as show
        $internshipRequest->update($request->except("status") + ["status" => config("global.internship_request_status.not_seen")]);
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
        $departmentHeadService = new DepartmentHeadService;

        switch ($request->decision) {
            case "accept":
                return  $departmentHeadService->acceptTheInternshipRequest_DepartmentHead($request, $internshipRequest, new InternshipResponsibleService);
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


        $internshipResponsibleService = new InternshipResponsibleService;

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

    public function internshipsAcceptedByInternshipResponsible()
    {
        if (Auth::getDefaultDriver() == config('global.internship_responsible_guard')) {
            $internshipRequests = InternshipResponsible::find(auth()->id())->internshipsAcceptedByInternshipResponsible();
        } else if (Auth::getDefaultDriver() == config('global.student_guard')) {
            $internshipRequests = Student::find(auth()->id())->internshipsAcceptedByInternshipResponsible();
        }
        return $this->returnData(InternshipRequestResource::collection($internshipRequests));
    }

    public function internshipsIAcceptedByDepartmentHead()
    {

        switch (Auth::getDefaultDriver()) {
            case config('global.student_guard'):
                $internshipRequests = Student::find(auth()->id())->internshipsIAcceptedByDepartmentHead();
                return $this->returnData(InternshipRequestResource::collection($internshipRequests));
            case config('global.internship_responsible_guard'):
                $internshipRequests = InternshipResponsible::find(auth()->id())->internshipsWaiting();
                return $this->returnData(InternshipRequestResource::collection($internshipRequests));

            case config('global.department_head_guard'):
                $internshipRequests = auth()->user()->department->internshipsAcceptedByDepartmentHead();
                return $this->returnData(InternshipRequestResource::collection($internshipRequests));
        }
        abort(403);
    }

    public function internshipsIAcceptedByStudent()
    {
        // todo the auth sould be interndhip respo
        if (Auth::getDefaultDriver() == config('global.internship_responsible_guard')) {
            $internshipRequests = InternshipResponsible::find(auth()->id())->internshipsIAcceptedByStudent();
            return $this->returnData(InternshipRequestResource::collection($internshipRequests));
        }
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

    public function refusedInternships()
    {
        // passed student internships
        if (Auth::getDefaultDriver() == config('global.student_guard')) {
            $internshipRequests = Student::find(auth()->id())->refusedInternships();
            return $this->returnData(InternshipRequestResource::collection($internshipRequests));
        }
        abort(403);
    }
    public function myPassedInternships()
    {
        // passed student internships
        if (Auth::getDefaultDriver() == config('global.student_guard')) {
            $internshipRequests = Student::find(auth()->id())->passedInternships();
            return $this->returnData(InternshipRequestResource::collection($internshipRequests));
        }
        abort(403);
    }
    public function getPDF(InternshipRequest $internshipRequest, PDFGenerateService $PDFGenerateService)
    {
        // passed student internships
        if (!Auth::getDefaultDriver() == config('global.internship_responsible_guard')) {
            abort(403);
        }
        $authorized_ids = InternshipResponsible::find(auth()->id())->internshipsIAcceptedByStudentId();
        if (!in_array($internshipRequest->id, $authorized_ids)) {
            abort(403);
        }
        $res = $PDFGenerateService->get_pdf($internshipRequest);
        return $this->returnData($res, 'PDF generated successfully!');

        // return $this->returnData(InternshipRequestResource::collection($internshipRequests));
    }
    public function accept_my_internship(InternshipRequest $internshipRequest, StudentService $student_service)
    {
        // passed student internships
        if (!Auth::getDefaultDriver() == config('global.student_guard')) {
            abort(403);
        }
        $authorized_ids = Student::find(auth()->id())->internshipsAcceptedByInternshipResponsibleId();
        if (!in_array($internshipRequest->id, $authorized_ids)) {
            abort(403);
        }
        $student_service->accept_internship($internshipRequest);
        return $this->returnSuccessMessage("Done");
    }
}
