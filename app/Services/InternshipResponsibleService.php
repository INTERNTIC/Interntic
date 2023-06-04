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
    public function create_account_if_not_found($internshipResponsible_email, $company_id)
    {
        $internshipResponsible = InternshipResponsible::findByEmail($internshipResponsible_email);

        if (!$internshipResponsible) {
            $internshipResponsible_password = Str::random(10);

            $internshipResponsibleRequest = new InternshipResponsibleRequest();
            $internshipResponsibleRequest->merge([
                'first_name' => 'first_name',
                'last_name' => 'last_name',
                'phone' => "00000000",
                'email' => $internshipResponsible_email,
                'password' => bcrypt($internshipResponsible_password),
                'company_id' => $company_id,
            ]);

            $validatedData = $internshipResponsibleRequest->validate($internshipResponsibleRequest->rules());
            $internshipResponsible =  InternshipResponsible::create($validatedData);
            $credentials = [
                "email" => $internshipResponsible_email,
                "password" => $internshipResponsible_password
            ];
            $data = [
                // 'internship_responsible' => $internshipResponsible,
                'credentials' => $credentials
            ];
            $this->sendEmail($data, $internshipResponsible_email, 'CreatingInternshipResponsibleAccount', 'Creating Internship Responsible Account');
        } else {
            $this->sendEmail([], $internshipResponsible_email, 'notify_internship_head_new_request', 'New internship request');
        }
    }
    public function acceptTheInternshipRequest_InternshipResponsible(InternshipRequest $internshipRequest)
    {
        $studentAccount = StudentAccount::find($internshipRequest->student_id);
        $data = ["internship_request" => $internshipRequest];
        $this->sendEmail($data, $studentAccount->email, 'AcceptedStudentInternshipRequest', 'Accepted Student Internship Request');

        $internshipRequest->status = config('global.internship_request_status.accepted_by_internship_responsible');
        $internshipRequest->save();

        return $this->returnSuccessMessage('Internship Request Accepted Successfully');
    }
    public function refuseTheInternshipRequest_InternshipResponsible(Request $request, InternshipRequest $internshipRequest)
    {
        $companyCause = CompanyCause::find($request->cause_id);
        $studentAccount = StudentAccount::find($internshipRequest->student_id);
        $data = [
            'company_cause' => $companyCause,
            'internship_request' => $internshipRequest,
            'status' => false
        ];
        $this->sendEmail($data, $studentAccount->email, 'RefusedInternshipRequest_company', 'Refused Internship Request');

        $companyRefuseRequest = [
            'internship_request_id' => $internshipRequest->id,
            'company_cause_id' => $request->cause_id
        ];

        $companyRefuse = CompanyRefuse::create($companyRefuseRequest);
        $internshipRequest->status = config('global.internship_request_status.refused_by_internship_responsible');
        $internshipRequest->save();


        return $this->returnSuccessMessage('Internship Request Refused in order to be edited');
    }


    public function refuse_definitivelyTheInternshipRequest_InternshipResponsible(Request $request, InternshipRequest $internshipRequest)
    {
        $companyCause = CompanyCause::find($request->cause_id);
        $studentAccount = StudentAccount::find($internshipRequest->student_id);
        $data = [
            'company_cause' => $companyCause,
            'internship_request' => $internshipRequest,
            'status' => true
        ];

        $this->sendEmail($data, $studentAccount->email, 'RefusedInternshipRequest_company', 'Refused Internship Request');
        $internshipRequest->delete();
        return $this->returnSuccessMessage('Internship Request Refused definitively');
    }
}
