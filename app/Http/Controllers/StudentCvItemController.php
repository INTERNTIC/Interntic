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
        // TODO save mitliple img
        // TODO count number of <br> to escape long posts 
        // TODO try to avoid java script here

        // $path = $request->file('image')->store('temp');
        // $file = $request->file('image');
        // $fileName = $file->getClientOriginalName();
        // $file->move(public_path('uploads'), $fileName);




        $files = [];

        if ($request->file('image')) {

            foreach ($request->file('image') as $key => $file) {
                $fileName = time() . $key . '.' . $file->extension();

                $file->move(public_path('uploads'), $fileName);

                // array of files
                array_push($files, $fileName);
                // $files[] = $fileName;

            }
        }
        $addData = [
            'student_id' => auth()->id(),
            "image" => implode("|", $files)

        ];
        $studentCvItem = StudentCvItem::create($request->only('details') + $addData);

        return $this->returnData($studentCvItem);
    }

    public function show(StudentCvItem $studentCvItem)
    {
        return $this->returnData($studentCvItem);
    }
    public function update(StudentCvItemRequest $request, StudentCvItem $studentCvItem)
    {
        $files = [];

        if ($request->file('image')) {

            foreach ($request->file('image') as $key => $file) {
                $fileName = time() . $key . '.' . $file->extension();

                $file->move(public_path('uploads'), $fileName);

                // array of files
                array_push($files, $fileName);
                // $files[] = $fileName;

            }
        }
        $addData = [
            "image" => $studentCvItem->image."|".implode("|", $files)
        ];

        $studentCvItem->update($request->only("details")+$addData);
        return $this->returnData($request->only('details') );
    }
    public function destroy(StudentCvItem $studentCvItem)
    {
        $studentCvItem->delete();
        return $this->returnSuccessMessage('Item deleted successfully');
    }
}
