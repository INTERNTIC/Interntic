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
Route::post('/login/{guard}',[AuthController::class,"login"]);
Route::post('/loginWithToken/{guard}',[AuthController::class,"loginWithToken"]);
Route::post('/logout',[AuthController::class,"logout"]);

//Super admin part
Route::post('/addDepartmentHead',[SuperAdmin::class,"addDepartmentHead"]);
Route::post('/editDepartmentHead',[SuperAdmin::class,"editDepartmentHead"]);

// Department head part
Route::post('/addStudentInfo',[DepartmentHeadController::class,"addStudentInfo"]);
Route::post('/editStudentInfo',[DepartmentHeadController::class,"editStudentInfo"]);
Route::post('/deleteStudent',[DepartmentHeadController::class,"deleteStudent"]);


//Student part
Route::post('/studentCreateAccount',[StudentController::class,"studentCreateAccount"]);
Route::post('/emailVerification/{token}',[StudentController::class,"emailVerification"])->name('emailVerification');

//Internship responsible part
Route::post('/accountRequest',[InternshipResponsibleController::class,"accountRequest"]);

