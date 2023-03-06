<?php

namespace App\Http\Controllers;

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

    public function diplayStudents()
    {
        $students=DB::table('students')->get();
        if($students==false)
        {
            return $this->returnError('No student to display');
        }
        return $this->returnData($students);
    }

    public function editStudentInfo(Request $request,$id)
    {
        return $request->all();
        $student= Student::find($id);
        if($student==false) {
            return $this->returnError('Student not found');
        }

        Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'birthday'=>'required',
            'place_of_birth'=>'required',
            'phone'=>'required',
            'student_card'=>'required',
            'social_security_num'=>'required',
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

    public function getStudent($id)
    {
        $student = Student::find($id);
    
        if($student==false) {
            return $this->returnError('Something went wrong');
        }
        return $this->returnData($student);
    }

    public function deleteStudent($id) 
    {
        $student = Student::find($id);
        $account = StudentAccount::find($id);

        if($student==false) {
            return $this->returnError('Something went wrong');
        }
 
        if ($account==true) {
            $account->delete();
        }
        
        $student->delete();
        return $this->returnSuccessMessage('Student deleted successfully');
    }
    
    public function studentCreateAccount(Request $request)
    {
        Validator::make($request->all(),[
            'student_card_number'=>'required',
            'email'=>['required','ends_with:univ-constantine2.dz','unique:student_accounts'],
            'password'=>['required','min:6'],
        ])->validate();
        
        
        $student_id = DB::table('students')->where('student_card', $request->student_card_number)->value('id');
        
        if ($student_id==false) {
            return $this->returnError('Please be sure about your card number or contact your department head');
        }
        
        $token = Str::random(64);
        $email=$request->email;

        StudentAccount::create([ 
            'id'=>$student_id,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'token'=>$token,
        ]);
        $data=[];
        $data['token']=$token;
        Mail::send('verificationMail',$data ,function($message) use($token,$email) 
        {
            $message -> subject('Email verification');
            $message->to($email);
        });
    }

    public function emailVerification($token)
    {
         $student_account= StudentAccount::where('token', $token)->get()->first();
         $student_account->update([ 
            'email_verified'=>1,
            'token'=>null
        ]);
    }

    public function studentResetPasword(Request $request,$id)
    {
        Validator($request->all(),[
            'old_password'=>'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ])->validate();

        $student=StudentAccount::find($id);
        if($student==false)
        {
            return $this->returnError('Something went wrong');
        }
       if (Hash::check($request->old_password, $student->password)) {
            $student->update([
                'password'=>Hash::make($request->password),
            ]);
        }
        else
        {
            return $this->returnError('Old password is incorrect');
        }
        return $this->returnSuccessMessage('Password updated successfully');
    }
   
}
