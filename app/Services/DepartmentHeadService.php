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
        $company_id=$internshipRequest->company;

        $data=$internshipResponsibleService->findOrCreate($internshipResponsible_email,$company_id);

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
}
