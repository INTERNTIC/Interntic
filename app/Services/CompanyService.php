<?php

namespace App\Services;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;

class CompanyService
{
    public function findOrCreate($name,$location)
    {
        $company = Company::findByNameLocation($name,$location);
        if($company){
            return $company;
        }else{
        $companyRequest = new CompanyRequest([
            'name' => $name,
            'location' => $location
        ]);
        $companyRequest = app()->make(CompanyRequest::class);
        return   Company::create($companyRequest->validated());
        }
		
    }
}
