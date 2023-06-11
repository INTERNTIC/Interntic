<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\AccountRequest;
use Illuminate\Validation\Rule;
use App\Services\CompanyService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CompanyController;
use App\Http\Requests\AccountRequest_Request;
use App\Http\Resources\AccountRequestResource;
use App\Http\Requests\InternshipResponsibleRequest;
use App\Traits\SendEmail;

class AccountRequestController extends Controller
{
    use GeneralTrait;
    use SendEmail;
    public $decisions = ['accept', 'refuse'];

    public function index()
    {
        return $this->returnData(AccountRequestResource::collection(AccountRequest::all()));
    }

    public function store(AccountRequest_Request $request,CompanyService $companyService)
    {
        $company_name = $request->company_name;
        $company_location = $request->company_location;

        $company = $companyService->findOrCreate($company_name,$company_location);
        $data = $request->only([
            'first_name',
            'last_name',
            'email',
            'phone',
            'company_id'
        ]);
        $data['company_id'] = $company->id;
        $data['password'] = bcrypt($request->password);
        $accountRequest = AccountRequest::create($data);
        // TODO make account accepted by souper admin
        $msg="your account is waiting to be confirmed by department head";
        return $this->returnData(new AccountRequestResource($accountRequest),$msg);
    }

    public function show(AccountRequest $accountRequest)
    {
        return $this->returnData(new AccountRequestResource($accountRequest));
    }
    public function destroy(AccountRequest $accountRequest)
    {
        $accountRequest->delete();
        return $this->returnSuccessMessage('Account Request deleted Successfuly');
    }
    public function manageAccountRequest(Request $request, AccountRequest $accountRequest)
    {
        // department head auth
        Validator::make($request->all(), [
            'decision' => ['required',  Rule::in($this->decisions)]
        ])->validate();
        switch ($request->decision) {
            case 'accept':
                return $this->acceptAccountRequest($request, $accountRequest);
                break;
            case 'refuse':
                $accountRequest->delete();
                return $this->returnSuccessMessage('account request refused successfully');
                break;
        }
    }
    public function acceptAccountRequest($request, AccountRequest $accountRequest)
    {
        $internshipResponsibleRequest = new InternshipResponsibleRequest([
            'first_name' => $accountRequest->first_name,
            'last_name' => $accountRequest->last_name,
            'phone' => $accountRequest->phone,
            'email' => $accountRequest->email,
            'password' => $accountRequest->password,
            'company_id' => $accountRequest->company_id,
        ]);
        
        $internshipResponsibleRequest
        ->setContainer(app())
        ->setRedirector(app(\Illuminate\Routing\Redirector::class))
        ->validateResolved();
        $internshipResponsible = (new InternshipResponsibleController)->store($internshipResponsibleRequest)->getOriginalContent()['data'];


        if($internshipResponsible==true){
            $accountRequest->delete();
            $this->sendEmail([],$accountRequest->email,"account_created","account created");
            return $this->returnSuccessMessage('account request accepted successfully');
        }else{
            return $this->returnError('Unable to accept the account request');
        }
    }

}
