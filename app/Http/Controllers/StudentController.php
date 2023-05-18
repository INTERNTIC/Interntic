<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Traits\GeneralTrait;

class StudentController extends Controller
{
    use GeneralTrait;

    public function addStudentInfo(StudentRequest $request)
    {
        $level_major_id = DB::table('level_major')->where('level_id', $request->level_id)->where('major_id', $request->major_id)->value('id');
        Student::create($request->validated() + ["level_major_id" => $level_major_id]);
        return $this->returnSuccessMessage('Created successfully');
    }
    
    public function diplayStudents()
    {
        // TODO check this for no student if ther is an Error
        $students = Student::with("level_major.level")->get();
        return $this->returnData(StudentResource::collection($students));
    }

    public function editStudentInfo(StudentRequest $request, Student $student)
    {
        // TODO validate the date form , also in store function
        $level_major_id = DB::table('level_major')->where('level_id', $request->level_id)->where('major_id', $request->major_id)->value('id');
        $guard = Auth::getDefaultDriver();
        if ($guard == config('global.department_head_guard')) {
            $student->update($request->validated() + ["level_major_id" => $level_major_id]);
            
        }else if($guard == config('global.student_guard')){
            $student->update($request->only("phone") );
        }
        return $this->returnData($student,"Updated successfully");
    }

    public function getStudent(Student $student)
    {
        return $this->returnData($student);
    }

    public function deleteStudent(Student $student)
    {

        $account = StudentAccount::find($student->id);



        if ($account == true) {
            $account->delete();
        }

        $student->delete();
        return $this->returnSuccessMessage('Student deleted successfully');
    }

    public function studentCreateAccount(Request $request)
    {
        Validator::make($request->all(), [
            'student_card' => 'required',
            'email' => ['required', 'ends_with:univ-constantine2.dz', 'unique:student_accounts'],
            'password' => ['required', 'min:6'],
        ])->validate();


        $student_id = DB::table('students')->where('student_card', $request->student_card_number)->value('id');

        if ($student_id == false) {
            return $this->returnError('Please be sure about your card number or contact your department head');
        }

        $token = Str::random(64);
        $email = $request->email;

        StudentAccount::create([
            'id' => $student_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'token' => $token,
        ]);
        $data = [];
        $data['token'] = $token;
        Mail::send('verificationMail', $data, function ($message) use ($token, $email) {
            $message->subject('Email verification');
            $message->to($email);
        });
    }

    public function emailVerification($token)
    {
        $student_account = StudentAccount::where('token', $token)->get()->first();
        $student_account->update([
            'email_verified' => 1,
            'token' => null
        ]);
    }

    // public function studentResetPasword(Request $request,$id)
    // {
    //     Validator($request->all(),[
    //         'old_password'=>'required',
    //         'password' => 'required|min:6|confirmed',
    //         'password_confirmation' => 'required|min:6'
    //     ])->validate();

    //     $student=StudentAccount::find($id);
    //     if($student==false)
    //     {
    //         return $this->returnError('Something went wrong');
    //     }
    //    if (Hash::check($request->old_password, $student->password)) {
    //         $student->update([
    //             'password'=>Hash::make($request->password),
    //         ]);
    //     }
    //     else
    //     {
    //         return $this->returnError('Old password is incorrect');
    //     }
    //     return $this->returnSuccessMessage('Password updated successfully');
    // }

}
