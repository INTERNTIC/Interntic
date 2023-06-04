<?php

namespace App\Http\Controllers;

use App\Traits\GeneralTrait;
use App\Models\StudentCvItem;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StudentCvItemRequest;
use App\Http\Resources\StudentCvItemResource;
use App\Models\Student;

class StudentCvItemController extends Controller
{
    // TODO try to remove any js script in deatails input "Warning"
    use GeneralTrait;

    public function index(Student $student)
    {
        switch (Auth::getDefaultDriver()) {
            case config('global.student_guard'):
                $student_cvs = StudentCvItem::where("student_id", auth()->id())->get();
                break;
            case (config('global.student_guard') || config('global.student_guard')):
                $student_cvs = StudentCvItem::where("student_id", $student->id)->get();
                break;
            default:
                abort(403);
                break;
            }
            return $this->returnData(StudentCvItemResource::collection($student_cvs));
    }

    public function store(StudentCvItemRequest $request)
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
        if (!$studentCvItem->image == "") {
            $addData = [
                "image" =>  implode("|", $files)
            ];
        } else {
            $imagesArray = explode("|", $studentCvItem->image);
            $addData = [
                "image" =>  implode("|", array_merge($imagesArray, $files))
            ];
        }



        // if (!empty($files)) {
        //     $addData = [
        //         "image" => $studentCvItem->image . "|" . implode("|", $files)
        //     ];
        // }

        $studentCvItem->update($request->only("details") + $addData);
        return $this->returnData($request->only('details'));
    }
    public function destroy(StudentCvItem $studentCvItem)
    {
        $studentCvItem->delete();
        return $this->returnSuccessMessage('Item deleted successfully');
    }
}
