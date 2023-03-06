<?php

namespace App\Http\Controllers;

use App\Models\CompanyRefuse;
use App\Http\Requests\CompanyRefuseRequest;

class CompanyRefuseController extends Controller
{

    public function index()
    {
        return $this->returnData(CompanyRefuse::all());
    }


    public function store(CompanyRefuseRequest $request)
    {
        $companyRefuse=CompanyRefuse::create($request->validated());
        return $this->returnData($companyRefuse);
    }

 
    public function show(CompanyRefuse $companyRefuse)
    {
        return $this->returnData($companyRefuse);
    }
   
    public function destroy(CompanyRefuse $companyRefuse)
    {
        $companyRefuse->delete();
        return $this->returnSuccessMessage('CompanyRefuse deleted successfully');
    
    }
}
