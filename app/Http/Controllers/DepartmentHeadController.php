<?php


namespace App\Http\Controllers;

use App\Models\AccountRequest;
use App\Models\Company;
use App\Models\InternshipRequest;
use App\Models\InternshipResponssible;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentAccount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

    public function diplayStudents()
    {
        $students=DB::table('students')->get();
        if($students==false)
        {
            return $this->returnError('No student to display');
        }
        return $this->returnData($students);
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


    public function manageAccountRequest(Request $request)
    {
        $account_request=AccountRequest::where('id',$request->id)->get()->first();

        $data=[];
        $email=$account_request->email;
        $data['full_name']=$account_request->first_name." ".$account_request->last_name;
    
        if($request->decision=='accept')
        {
            $company_id=DB::table('companies')->where('name',$account_request->company_name)->where('location',$account_request->company_location)->value('id');
            if($company_id==false)
            {
                Company::create([
                    'name'=>$account_request->company_name,
                    'location'=>$account_request->company_location
                ]);

                $company_id=DB::table('companies')->where('name',$account_request->company_name)->where('location',$account_request->company_location)->value('id');
            }
           
            InternshipResponssible::create([
                'first_name'=>$account_request->first_name,
                'last_name'=>$account_request->last_name,
                'email'=>$account_request->email,
                'password'=>$account_request->password,
                'phone'=>$account_request->phone,
                'company_id'=>$company_id
            ]);

           
            Mail::send('validationAccount',$data ,function($message) use($email)
            {
                $message -> subject('Account validation');
                $message->to($email);
            });

            $account_request->delete();
        }
        else
        {
            Mail::send('refusingAccount',$data ,function($message) use($email)
            {
                $message -> subject('Account Refusing');
                $message->to($email);
            });

            $account_request->delete();
        }
    }
}