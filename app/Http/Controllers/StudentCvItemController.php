<?php

namespace App\Http\Controllers;

use App\Models\StudentCvItem;
use App\Http\Requests\StudentCvItemRequest;
use App\Traits\GeneralTrait;
class StudentCvItemController extends Controller
{
    // TODO try to remove any js script in deatails input "Warning"
    use GeneralTrait;

    public function index()
    {
        return $this->returnData(StudentCvItem::all());
    }

    public function store(StudentCvItemRequest $request)
    {
        $studentCvItem = StudentCvItem::create($request->validated()+['student_id'=>auth()->id()]);
        return $this->returnData($studentCvItem);
    }

    public function show(StudentCvItem $studentCvItem)
    {
        return $this->returnData($studentCvItem);
    }
    public function update(StudentCvItemRequest $request, StudentCvItem $studentCvItem)
    {
        $studentCvItem->update($request->validated());
        return $this->returnData(($studentCvItem));
    }
    public function destroy(StudentCvItem $studentCvItem)
    {
        $studentCvItem->delete();
        return $this->returnSuccessMessage('Item deleted successfully');
    }
}
