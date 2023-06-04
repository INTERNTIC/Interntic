<?php


namespace App\Http\Controllers;

use App\Http\Requests\DepartmentHeadRequest;
use App\Http\Resources\DepartmentHeadResource;
use App\Models\DepartmentHead;
use App\Traits\GeneralTrait;

class DepartmentHeadController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        $department_heads=DepartmentHead::all();
        return $this->returnData(DepartmentHeadResource::collection($department_heads));
    }

    public function store(DepartmentHeadRequest $request)
    {
       $department_head= DepartmentHead::create($request->except("password")+["password"=>bcrypt($request->password)]);
       return $this->returnData(new DepartmentHeadResource($department_head));
    }

    public function show(DepartmentHead $department_head)
    {
        return $this->returnData(new DepartmentHeadResource($department_head));
    }

    public function update(DepartmentHeadRequest $request,DepartmentHead $department_head)
    {
        $department_head->update($request->except("password"));
        return $this->returnData(new DepartmentHeadResource($department_head));
    }

    public function destroy(DepartmentHead $department_head)
    {
        $department_head->delete();
        return $this->returnSuccessMessage('Department head deleted successfully');
    }
}