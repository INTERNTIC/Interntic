<?php

namespace App\Http\Controllers;

use App\Models\DepartmentRefuse;
use App\Http\Requests\DepartmentRefuseRequest;

class DepartmentRefuseController extends Controller
{
   
    public function index()
    {
        return $this->returnData(DepartmentRefuse::all());
     
    }
    public function store(DepartmentRefuseRequest $request)
    {
        $departmentRefuse=DepartmentRefuse::create($request->validated());
        return $this->returnData($departmentRefuse);
    }

  
    public function show(DepartmentRefuse $departmentRefuse)
    {
        return $this->returnData($departmentRefuse);
    }


    public function destroy(DepartmentRefuse $departmentRefuse)
    {
        $departmentRefuse->delete();
        return $this->returnSuccessMessage('DepartmentRefuse deleted successfully');
    
    }
}
