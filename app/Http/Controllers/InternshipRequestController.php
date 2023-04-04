<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\SendEmail;
use App\Models\Department;
use Illuminate\Support\Str;
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
use App\Http\Requests\CompanyRequest;
use App\Models\InternshipResponsible;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\InternshipRequest_Request;
use App\Http\Resources\InternshipRequestResource;
use App\Http\Requests\InternshipResponsibleRequest;

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
            $internshipRequests = InternshipResponsible::find(auth()->id())->studentsIntershipRequests();
        }

        return $this->returnData(InternshipRequestResource::collection($internshipRequests));
    }


    public function store(InternshipRequest_Request $request)
    {
        // TODO only student
        // TODO check if this request came with a hidden input called ...
        //  this last showing if the request is in refused tables(compnay/Departement) to ne deleted form the table 
        $company_name = $request->company_name;
        $company_location = $request->company_location;
        $companyRequest = new CompanyRequest([
            'name' => $company_name,
            'location' => $company_location
        ]);
        $company = (new CompanyController)->findOrCreate($companyRequest);

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

    public function update(InternshipRequest_Request $request, InternshipRequest $internshipRequest)
    {
        //    TDOO authorization same as show
        $company_name = $request->company_name;
        $company_location = $request->company_location;
        $companyRequest = new CompanyRequest([
            'name' => $company_name,
            'location' => $company_location
        ]);
        $company = (new CompanyController)->findOrCreate($companyRequest);

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
        switch ($request->decision) {
            case "accept":
                return  $this->acceptTheInternshipRequest_DepartmentHead($request, $internshipRequest);
                break;
            case "refuse":
                Validator::make($request->all(), [
                    'cause_id' => ['required', 'exists:department_causes,id']
                ])->validate();

                return  $this->refuseTheInternshipRequest_DepartmentHead($request, $internshipRequest);

                break;
            case "refuse_definitively":
                Validator::make($request->all(), [
                    'cause_id' => ['required', 'exists:department_causes,id']
                ])->validate();

                return  $this->refuse_definitivelyTheInternshipRequest_DepartmentHead($request, $internshipRequest);
                break;
        }
    }

    public function acceptTheInternshipRequest_DepartmentHead(Request $request, InternshipRequest $internshipRequest)
    {
        $company = $internshipRequest->company;
        $internshipResponsible_email = $internshipRequest->internshipResponsible_email;
        $internshipResponsible_password = Str::random(10);

        $isCreatedBefore = InternshipResponsible::where('email', '=', $internshipResponsible_email)->first();



        if ($isCreatedBefore == false) {
            $internshipResponsibleRequest = new InternshipResponsibleRequest([
                'first_name' => 'first_name',
                'last_name' => 'last_name',
                'phone' => "00000000",
                'email' => $internshipResponsible_email,
                'password' => bcrypt($internshipResponsible_password),
                'company_id' => $company->id,
            ]);


            $internshipResponsible = (new InternshipResponsibleController)->findOrCreate($internshipResponsibleRequest);
            $credentials = [
                "email" => $internshipResponsible_email,
                "password" => $internshipResponsible_password
            ];
            $data = [
                'internshipResponsible' => $internshipResponsible,
                'credentials' => $credentials
            ];
        } else {

            $internshipResponsible = $isCreatedBefore;
            $data = [
                'internshipResponsible' => $internshipResponsible,
            ];
        }

        $this->sendEmail($data, $internshipResponsible_email, 'CreatingInternshipResponsibleAccount', 'Creating Internship Responsible Account');
        $internshipRequest->status = config('global.internship_request_status.accepted_by_department_head');
        $internshipRequest->save();


        return $this->returnSuccessMessage('Internship Request Accepted Successfully');
    }

    public function refuseTheInternshipRequest_DepartmentHead(Request $request, InternshipRequest $internshipRequest)
    {
        $departmentCause = DepartmentCause::find($request->cause_id);
        $student = Student::find($internshipRequest->student_id);
        $studentAccount = StudentAccount::find($internshipRequest->student_id);
        $data = [
            'departmentCause' => $departmentCause,
            'internshipRequest' => $internshipRequest,
            'student' => $student
        ];

        $departmentRefuseRequest = [
            'internship_request_id' => $internshipRequest->id,
            'department_cause_id' => $request->cause_id
        ];

        $departmentRefuse = DepartmentRefuse::create($departmentRefuseRequest);
        $this->sendEmail($data, $studentAccount->email, 'RefusedInternshipRequest', 'Refused Internship Request');
        $internshipRequest->status = config('global.internship_request_status.refused_by_department_head');
        $internshipRequest->save();


        return $this->returnSuccessMessage('Internship Request Refused in order to be edited');
        // TODO test this method of insert
    }

    public function refuse_definitivelyTheInternshipRequest_DepartmentHead(Request $request, InternshipRequest $internshipRequest)
    {
        $departmentCause = DepartmentCause::find($request->cause_id);
        $student = Student::find($internshipRequest->student_id);
        $studentAccount = StudentAccount::find($internshipRequest->student_id);
        $data = [
            'departmentCause' => $departmentCause,
            'internshipRequest' => $internshipRequest,
            'student' => $student
        ];

        $this->sendEmail($data, $studentAccount->email, 'RefusedInternshipRequest', 'Refused Internship Request');
        $internshipRequest->delete();
        return $this->returnSuccessMessage('Internship Request Refused definitively');
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
        switch ($request->decision) {
            case "accept":
                return  $this->acceptTheInternshipRequest_InternshipResponsible($request, $internshipRequest);
                break;
            case "refuse":
                Validator::make($request->all(), [
                    'cause_id' => ['required', 'exists:company_causes,id']
                ])->validate();

                return  $this->refuseTheInternshipRequest_InternshipResponsible($request, $internshipRequest);

                break;
            case "refuse_definitively":
                Validator::make($request->all(), [
                    'cause_id' => ['required', 'exists:company_causes,id']
                ])->validate();

                return  $this->refuse_definitivelyTheInternshipRequest_InternshipResponsible($request, $internshipRequest);
                break;
        }
    }

    public function acceptTheInternshipRequest_InternshipResponsible(Request $request, InternshipRequest $internshipRequest)
    {
        $studentAccount = StudentAccount::find($internshipRequest->student_id);
        $this->sendEmail($internshipRequest->toArray(), $studentAccount->email, 'AcceptedStudentInternshipRequest', 'Accepted Student Internship Request');

        $internshipRequest->status = config('global.internship_request_status.accepted_by_internship_responsible');
        $internshipRequest->save();

        return $this->returnSuccessMessage('Internship Request Accepted Successfully');
    }



    public function refuseTheInternshipRequest_InternshipResponsible(Request $request, InternshipRequest $internshipRequest)
    {
        $companyCause = CompanyCause::find($request->cause_id);
        $student = Student::find($internshipRequest->student_id);
        $studentAccount = StudentAccount::find($internshipRequest->student_id);
        $data = [
            'companyCause' => $companyCause,
            'internshipRequest' => $internshipRequest,
            'student' => $student
        ];
        $this->sendEmail($data, $studentAccount->email, 'RefusedInternshipRequest', 'Refused Internship Request');

        $companyRefuseRequest = [
            'internship_request_id' => $internshipRequest->id,
            'company_cause_id' => $request->cause_id
        ];

        $companyRefuse = CompanyRefuse::create($companyRefuseRequest);
        $internshipRequest->status = config('global.internship_request_status.refused_by_internship_responsible');
        $internshipRequest->save();


        return $this->returnSuccessMessage('Internship Request Refused in order to be edited');
        // TODO test this method of insert
    }


    public function refuse_definitivelyTheInternshipRequest_InternshipResponsible(Request $request, InternshipRequest $internshipRequest)
    {
        $companyCause = CompanyCause::find($request->cause_id);
        $student = Student::find($internshipRequest->student_id);
        $studentAccount = StudentAccount::find($internshipRequest->student_id);
        $data = [
            'companyCause' => $companyCause,
            'internshipRequest' => $internshipRequest,
            'student' => $student
        ];

        $this->sendEmail($data, $studentAccount->email, 'RefusedInternshipRequest', 'Refused Internship Request');
        $internshipRequest->delete();
        return $this->returnSuccessMessage('Internship Request Refused definitively');
    }
    public function studentInternships()
    {
        // todo the auth sould be interndhip respo
        if (Auth::getDefaultDriver() == config('global.internship_responsible_guard')) {
            $internshipRequests = InternshipResponsible::find(auth()->id())->studentsInterships();
        }
        return $this->returnData(InternshipRequestResource::collection($internshipRequests));
    }
}
