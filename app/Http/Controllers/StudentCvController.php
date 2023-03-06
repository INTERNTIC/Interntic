<?php

namespace App\Http\Controllers;

use App\Models\StudentCv;
use App\Http\Requests\StudentCvRequest;
use App\Traits\GeneralTrait;
class StudentCvController extends Controller
{
    // TODO try to remove any js script in deatails input "Warning"
    use GeneralTrait;

    public function index()
    {
        return $this->returnData(StudentCv::all());
    }

    public function store(StudentCvRequest $request)
    {
        $studentCv = StudentCv::create($request->validated()+['student_id'=>auth()->id()]);
        return $this->returnData($studentCv);
    }

    public function show(StudentCv $studentCv)
    {
        return $this->returnData($studentCv);
    }
    public function update(StudentCvRequest $request, StudentCv $studentCv)
    {
        $studentCv->update($request->validated());
        return $this->returnData(($studentCv));
    }
    public function destroy(StudentCv $studentCv)
    {
        $studentCv->delete();
        return $this->returnSuccessMessage('Item deleted successfully');
    }
}
