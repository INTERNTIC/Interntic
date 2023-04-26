<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Models\AccountRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\InternshipResponsible;
use Illuminate\Support\Facades\Validator; 
use App\Http\Requests\InternshipResponsibleRequest;

class InternshipResponsibleController extends Controller
{
    use GeneralTrait;

    public function responsibleResetPasword(Request $request,$id)
    {
        Validator($request->all(),[
            'old_password'=>'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ])->validate();

        $internship_responsible=InternshipResponsible::find($id);
        if($internship_responsible==false)
        {
            return $this->returnError('Something went wrong');
        }
       if (Hash::check($request->old_password, $internship_responsible->password)) {
            $internship_responsible->update([
                'password'=>Hash::make($request->password),
            ]);
        }
        else
        {
            return $this->returnError('Old password is incorrect');
        }
        return $this->returnSuccessMessage('Password updated successfully');
    }


    public function index()
    {
        return $this->returnData(InternshipResponsible::all());
    }


    public function store(InternshipResponsibleRequest $request)
    {
        $internshipResponsible=InternshipResponsible::create($request->validated());
        return $this->returnData($internshipResponsible);
    }

 
    public function show(InternshipResponsible $internshipResponsible)
    {
        return $this->returnData($internshipResponsible);
    }


    public function update(InternshipResponsibleRequest $request, InternshipResponsible $internshipResponsible)
    {
        $newRequest =$request->validated();
        unset($newRequest['password']);
        $internshipResponsible->update($newRequest);
        return $this->returnData($internshipResponsible);
    }
    
    public function destroy(InternshipResponsible $internshipResponsible)
    {
        $internshipResponsible->delete();
        return $this->returnSuccessMessage('deleted successfully');
    }


















}