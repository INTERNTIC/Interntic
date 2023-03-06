<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\SendEmail;
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
use App\Http\Requests\CompanyRequest;
use App\Models\InternshipResponsible;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\InternshipRequest_Request;
use App\Http\Resources\InternshipRequestResource;
use App\Http\Requests\InternshipResponsibleRequest;

class InternshipRequestController extends Controller
{
    public $decisions = ['accept', 'refuse', 'refsue_definitely'];
    use GeneralTrait, SendEmail;
    public function index()
    {
        return $this->returnData(InternshipRequestResource::collection(InternshipRequest::all()));
    }


    public function store(InternshipRequest_Request $request)
    {
        $internshipRequest = InternshipRequest::create($request->validated());
        return $this->returnData(new InternshipRequestResource($internshipRequest));
    }


    public function show(InternshipRequest $internshipRequest)
    {
        return $this->returnData(new InternshipRequestResource($internshipRequest));
    }

    public function update(InternshipRequest_Request $request, InternshipRequest $internshipRequest)
    {
        $internshipRequest->update($request->validated());
        return $this->returnData(new InternshipRequestResource($internshipRequest));
    }

    public function destroy(InternshipRequest $internshipRequest)
    {
        $internshipRequest->delete();
        return $this->returnSuccessMessage('Request deleted successfully');
    }



    public function manageTheInternshipRequest(Request $request, InternshipRequest $internshipRequest)
    {
        // TODO fix this header by testing auth guard
        Validator::make($request->all(), [
            'decision' => ['required',  Rule::in($this->decisions)]
        ])->validate();

        if ($request->header('guard') == 'department_head') {
           return $this->manageTheInternshipRequest_DepartmentHead($request, $internshipRequest);
        } elseif ($request->header('guard') == 'manageTheInternshipRequest') {
           return $this->manageTheInternshipRequest_InternshipResponsable($request, $internshipRequest);
        } else {
            abort(401);
        }
    }
    public function manageTheInternshipRequest_DepartmentHead(Request $request, InternshipRequest $internshipRequest)
    {
       
        // if dicition true
        // create account for respo
        // notification to respo

        // if dicition false diff
        // notification to student
        // deleted 


        // if dicition false 
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
            case "refsue_definitely":
                Validator::make($request->all(), [
                    'cause_id' => ['required', 'exists:department_causes,id']
                ])->validate();

              return  $this->refsue_definitelyTheInternshipRequest_DepartmentHead($request, $internshipRequest);
                break;
        }
    }

    public function acceptTheInternshipRequest_DepartmentHead(Request $request, InternshipRequest $internshipRequest)
    {

        $company_name = $internshipRequest->company_name;
        $company_location = $internshipRequest->company_location;
        $companyRequest = new CompanyRequest([
            'name' => $company_name,
            'location' => $company_location
        ]);


        $company = (new CompanyController)->findOrCreate($companyRequest);
        $internshipResponsible_email = $internshipRequest->internshipResponsible_email;
        $internshipResponsible_password = Str::random(10);
        
        $isCreatedBefore=InternshipResponsible::where('email','=',$internshipResponsible_email)->first();
        
        
        
        if($isCreatedBefore==false){
            $internshipResponsibleRequest = new InternshipResponsibleRequest( [
                'first_name' => 'first_name',
                'last_name' => 'last_name',
                'phone'=>"00000000",
                'email' => $internshipResponsible_email,
                'password' => bcrypt($internshipResponsible_password),
                'company_id' => $company->id,
            ]);

            
            $internshipResponsible = (new InternshipResponsibleController)->findOrCreate($internshipResponsibleRequest);
            $credentials = [
                "email" => $internshipResponsible_email,
                "password" => $internshipResponsible_password
            ];
            $data=[
                'internshipResponsible'=>$internshipResponsible,
                'credentials'=>$credentials
            ];
        }else{

            $internshipResponsible=$isCreatedBefore;   
            $data=[
                'internshipResponsible'=>$internshipResponsible,
            ];
        }

        $this->sendEmail($data, $internshipResponsible_email, 'CreatingInternshipResponsibleAccount', 'Creating Internship Responsible Account');

        return $this->returnSuccessMessage('Internship Request Accepted Successfully');
    }

    public function refuseTheInternshipRequest_DepartmentHead(Request $request, InternshipRequest $internshipRequest)
    {
        $departmentCause=DepartmentCause::find($request->cause_id);
        $student=Student::find($internshipRequest->student_id);
        $studentAccount=StudentAccount::find($internshipRequest->student_id);
        $data=['departmentCause'=>$departmentCause,
        'internshipRequest'=>$internshipRequest,
        'student'=>$student];
        $this->sendEmail($data, $studentAccount->email, 'RefusedInternshipRequest', 'Refused Internship Request');

        $departmentRefuseRequest = [
            'internship_request_id'=>$internshipRequest->id,
            'department_cause_id'=>$request->cause_id
        ];

        $departmentRefuse = DepartmentRefuse::create($departmentRefuseRequest);

        return $this->returnSuccessMessage('Internship Request Refused in order to be edited');
        // TODO test this method of insert
    }

    public function refsue_definitelyTheInternshipRequest_DepartmentHead(Request $request, InternshipRequest $internshipRequest)
    {
        $departmentCause=DepartmentCause::find($request->cause_id);
        $student=Student::find($internshipRequest->student_id);
        $studentAccount=StudentAccount::find($internshipRequest->student_id);
        $data=[
            'departmentCause'=>$departmentCause,
            'internshipRequest'=>$internshipRequest,
            'student'=>$student];
           
        $this->sendEmail($data, $studentAccount->email, 'RefusedInternshipRequest', 'Refused Internship Request');
        $internshipRequest->delete();
        return $this->returnSuccessMessage('Internship Request Refused Definitely');
    }





    public function manageTheInternshipRequest_InternshipResponsable(Request $request, InternshipRequest $internshipRequest)
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
              return  $this->acceptTheInternshipRequest_InternshipResponsable($request, $internshipRequest);
                break;
            case "refuse":
                Validator::make($request->all(), [
                    'cause_id' => ['required', 'exists:company_causes,id']
                ])->validate();

              return  $this->refuseTheInternshipRequest_InternshipResponsable($request, $internshipRequest);

                break;
            case "refsue_definitely":
                Validator::make($request->all(), [
                    'cause_id' => ['required', 'exists:company_causes,id']
                ])->validate();

              return  $this->refsue_definitelyTheInternshipRequest_InternshipResponsable($request, $internshipRequest);
                break;
        }
    }
     
    public function acceptTheInternshipRequest_InternshipResponsable(Request $request, InternshipRequest $internshipRequest)
    {
      $studentAccount=StudentAccount::find($internshipRequest->student_id);
        $this->sendEmail($internshipRequest, $studentAccount->email, 'AcceptedStudentInternshipRequest', 'Accepted Student Internship Request');

        $internshipRequest->update(['status' => true]);
        return $this->returnSuccessMessage('Internship Request Accepted Successfully');
    }



    public function refuseTheInternshipRequest_InternshipResponsable(Request $request, InternshipRequest $internshipRequest)
    {
        $companyCause=CompanyCause::find($request->cause_id);
        $student=Student::find($internshipRequest->student_id);
        $studentAccount=StudentAccount::find($internshipRequest->student_id);
        $data=['companyCause'=>$companyCause,
        'internshipRequest'=>$internshipRequest,
        'student'=>$student];
        $this->sendEmail($data, $studentAccount->email, 'RefusedInternshipRequest', 'Refused Internship Request');

        $companyRefuseRequest = [
            'internship_request_id'=>$internshipRequest->id,
            'company_cause_id'=>$request->cause_id
        ];

        $companyRefuse = CompanyRefuse::create($companyRefuseRequest);

        return $this->returnSuccessMessage('Internship Request Refused in order to be edited');
        // TODO test this method of insert
    }


    public function refsue_definitelyTheInternshipRequest_InternshipResponsable(Request $request, InternshipRequest $internshipRequest)
    {
        $companyCause=CompanyCause::find($request->cause_id);
        $student=Student::find($internshipRequest->student_id);
        $studentAccount=StudentAccount::find($internshipRequest->student_id);
        $data=[
            'companyCause'=>$companyCause,
            'internshipRequest'=>$internshipRequest,
            'student'=>$student];
           
        $this->sendEmail($data, $studentAccount->email, 'RefusedInternshipRequest', 'Refused Internship Request');
        $internshipRequest->delete();
        return $this->returnSuccessMessage('Internship Request Refused Definitely');
    }


}
