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

class StudentController extends Controller 
{
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
   
}
