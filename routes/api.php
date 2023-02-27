<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin;
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\StudentController; 
use App\Http\Controllers\InternshipResponsibleController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

/* 
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Authentication part

Route::controller(AuthController::class)->group(function (){
    Route::post('/login/{guard}',"login");
  Route::group(['middleware'=>'check.auth.guard'],function(){
    Route::post('/loginWithToken',"loginWithToken"); 
  });
    Route::post('/logout',"logout");
    Route::post('/askResetPassword/{guard}','askResetPassword');   
    Route::post('/resetPassword','resetPassword')->name('resetPassword');
});

//Student part
Route::controller(StudentController::class)->middleware(['auth:student'])->group(function (){
    Route::post('/studentCreateAccount',"studentCreateAccount");
    Route::post('/emailVerification/{token}',"emailVerification")->name('emailVerification');
});



//Super admin part
Route::controller(SuperAdmin::class)->middleware(['auth:super_admin'])->group(function (){
    Route::post('/addDepartmentHead',"addDepartmentHead");
    Route::post('/editDepartmentHead',"editDepartmentHead");
});


// Department head part
Route::controller(DepartmentHeadController::class)->middleware(['auth:department_head'])->group(function (){
    Route::post('/addStudentInfo',"addStudentInfo");
    Route::post('/editStudentInfo',"editStudentInfo");
    Route::post('/deleteStudent',"deleteStudent");
    
});


//Internship responsible part
Route::controller(InternshipResponsibleController::class)->middleware(['auth:internship_responssible'])->group(function (){
    Route::post('/accountRequest',[InternshipResponsibleController::class,"accountRequest"]);
});



