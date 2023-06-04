<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyService
{
    public function findOrCreate($name, $location)
    {
        $company = Company::findByNameLocation($name, $location);
        if ($company) {
            return $company;
        } else {

            $rq = new Request([
                'name' => $name,
                'location' => $location
            ]);
            // $companyRequest = new CompanyRequest([
            //     'name' => $name,
            //     'location' => $location
            // ]);
            // $companyRequest = app()->make(CompanyRequest::class);
            return   Company::create($rq->all());
        }
    }
}
