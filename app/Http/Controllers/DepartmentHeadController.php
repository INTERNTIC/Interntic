<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Traits\GeneralTrait;

class DepartmentHeadController extends Controller

{
    public function addStudentInfo(Request $request)
    {
       Validator::make($request->all(),[

            'first_name'=>'required',
            'last_name'=>'required',
            'birthday'=>'required',
            'place_of_birth'=>'required',
            'phone_number'=>['required','numeric'],
            'student_card_number'=>['required','unique:students,student_card'],
            'social_security_num'=>['required','unique:students'],
            'level'=>'required',
            'major'=>'required',
        ])->validate();

        $level_major_id = DB::table('level_major')->where('level_id', $request->level)->where('major_id',$request->major)->value('id');

        Student::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'place_of_birth'=>$request->place_of_birth,
            'phone'=>$request->phone_number,
            'student_card'=>$request->student_card_number,
            'social_security_num'=>$request->social_security_num,
            'level_major_id'=>$level_major_id,
        ]);
    }

    public function editStudentInfo(Request $request)
    {
        $student= Student::find($request->id);
        if($student==false) {
            return $this->returnError('Student not found');
        }

        Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'birthday'=>'required',
            'place_of_birth'=>'required',
            'phone'=>'required',
            'student_card'=>['required','unique:students'],
            'social_security_num'=>['required','unique:students'],
            'level'=>'required',
            'major'=>'required',
        ])->validate();

        $level_major_id = DB::table('level_major')->where('level_id', $request->level)->where('major_id',$request->major)->value('id');
        
        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birthday' => $request->birthday,
            'place_of_birth'=>$request->place_of_birth,
            'phone'=>$request->phone,
            'student_card'=>$request->student_card,
            'social_security_num'=>$request->social_security_num,
            'level_major_id'=>$level_major_id,
        ]);
    }

    public function deleteStudent(Request $request)
    {
        $student = Student::find($request->id);
        $account = StudentAccount::find($request->id);

        if($student==false) {
            return $this->returnError('Student not found');
        }
 
        if ($account==true) {
            $account->delete();
        }
        
        $student->delete();
        return $this->returnSuccessMessage('Student deleted successfully');
    }
}