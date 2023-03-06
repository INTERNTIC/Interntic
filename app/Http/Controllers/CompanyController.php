<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Traits\GeneralTrait;
use App\Http\Requests\CompanyRequest;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        return $this->returnData(Company::all());  
    }

    public function store(CompanyRequest $request)
    {
        $company=Company::create($request->validated());
        return $this->returnData($company);
    }


    public function show(Company $company)
    {
        return $this->returnData($company);
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $company->update($request->validated());
        return $this->returnData($company);
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return $this->returnSuccessMessage('Company deleted successfully');
    }
    public function findOrCreate(CompanyRequest $request)
	{
        $company = Company::where('name','=',$request->name)
        ->where('location','=',$request->location)->first();
        $request
        ->setContainer(app())
        ->setRedirector(app(\Illuminate\Routing\Redirector::class))
        ->validateResolved();
		return $company!=null? $company: Company::create($request->validated());
	}
}
