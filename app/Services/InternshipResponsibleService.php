<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Student;
use App\Traits\SendEmail;
use Illuminate\Support\Str;
use App\Models\CompanyCause;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\CompanyRefuse;
use App\Models\StudentAccount;
use App\Models\InternshipRequest;
use App\Http\Requests\CompanyRequest;
use App\Models\InternshipResponsible;
use App\Http\Requests\InternshipResponsibleRequest;

class InternshipResponsibleService
{
    use SendEmail;
    use GeneralTrait;
    public function findOrCreate($internshipResponsible_email, $company_id)
    {
        $internshipResponsible = InternshipResponsible::findByEmail($internshipResponsible_email);

        if ($internshipResponsible == false) {

            $internshipResponsible_password = Str::random(10);

            $internshipResponsibleRequest = new InternshipResponsibleRequest([
                'first_name' => 'first_name',
                'last_name' => 'last_name',
                'phone' => "00000000",
                'email' => $internshipResponsible_email,
                'password' => bcrypt($internshipResponsible_password),
                'company_id' => $company_id,
            ]);

            $internshipResponsibleRequest = app()->make(InternshipResponsibleRequest::class);
            $internshipResponsible =  InternshipResponsible::create($internshipResponsibleRequest->validated());
            $credentials = [
                "email" => $internshipResponsible_email,
                "password" => $internshipResponsible_password
            ];
            $data = [
                'internshipResponsible' => $internshipResponsible,
                'credentials' => $credentials
            ];
        } else {
            $data = [
                'internshipResponsible' => $internshipResponsible,
            ];
        }
        return $data;
    }
    public function acceptTheInternshipRequest_InternshipResponsible(InternshipRequest $internshipRequest)
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
}
