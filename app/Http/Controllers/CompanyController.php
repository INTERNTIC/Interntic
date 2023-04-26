<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Traits\GeneralTrait;
use App\Services\CompanyService;
use App\Http\Requests\CompanyRequest;

class CompanyController extends Controller
{
    use GeneralTrait;
    public function __construct(private CompanyService $companyService)
    {
    }

    public function index()
    {
        return $this->returnData(Company::all());
    }

    public function store(CompanyRequest $request)
    {
        $company = Company::create($request->validated());
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
    public function findOrCreate($name,$location)
    {
        return $this->companyService->findOrCreate($name,$location);
    }
}
