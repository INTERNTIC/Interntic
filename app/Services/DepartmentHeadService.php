<?php

namespace App\Services;

use App\Models\Student;
use App\Traits\SendEmail;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

use App\Models\StudentAccount;
use App\Models\DepartmentCause;
use App\Models\DepartmentRefuse;
use App\Models\InternshipRequest;

class DepartmentHeadService
{
    use SendEmail;
    use GeneralTrait;
   
    public function acceptTheInternshipRequest_DepartmentHead(Request $request, InternshipRequest $internshipRequest, InternshipResponsibleService $internshipResponsibleService)
    {
        $internshipResponsible_email = $internshipRequest->internshipResponsible_email;
        $company_id=$internshipRequest->company->id;
        
        $internshipResponsibleService->create_account_if_not_found($internshipResponsible_email,$company_id);

        $internshipRequest->status = config('global.internship_request_status.accepted_by_department_head');
        $internshipRequest->save();
        $this->sendEmail([], $internshipRequest->student->student_account->email, 'Department_head_validate_a_request', 'Internship Request Approved by Department Head');

        return $this->returnSuccessMessage('Internship Request Accepted Successfully');
    }

    public function refuseTheInternshipRequest_DepartmentHead(Request $request, InternshipRequest $internshipRequest)
    {
        $departmentCause = DepartmentCause::find($request->cause_id);
        $student = Student::find($internshipRequest->student_id);
        $studentAccount = StudentAccount::find($internshipRequest->student_id);
        $data = [
            'department_cause' => $departmentCause,
            'internship_request' => $internshipRequest,
            'student' => $student,
            'status'=>false
        ];

        $departmentRefuseRequest = [
            'internship_request_id' => $internshipRequest->id,
            'department_cause_id' => $request->cause_id
        ];

        // $departmentRefuse = DepartmentRefuse::create($departmentRefuseRequest);
        $this->sendEmail($data, $studentAccount->email, 'RefusedInternshipRequest_department', 'Refused Internship Request');
        $internshipRequest->status = config('global.internship_request_status.refused_by_department_head');
        $internshipRequest->save();


        return $this->returnSuccessMessage('Internship Request Refused in order to be edited');
    }

    public function refuse_definitivelyTheInternshipRequest_DepartmentHead(Request $request, InternshipRequest $internship_request)
    {
        $department_cause = DepartmentCause::find($request->cause_id);
        $student = Student::find($internship_request->student_id);
        $studentAccount = StudentAccount::find($internship_request->student_id);
        $data = [
            'department_cause' => $department_cause,
            'internship_request' => $internship_request,
            'student' => $student,
            'status'=>true,
        ];

        $this->sendEmail($data, $studentAccount->email, 'RefusedInternshipRequest_department', 'Refused Internship Request');
        $internship_request->delete();
        return $this->returnSuccessMessage('Internship Request Refused definitively');
    }
}
