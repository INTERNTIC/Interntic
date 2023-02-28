<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\StudentController; 
use App\Http\Controllers\InternshipResponsibleController;
use App\Http\Controllers\InternshipAccountsRequestsController;
use App\Http\Controllers\InternshipOffersController;
use App\Models\InternshipResponsible;
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
Route::post('/askResetPassword/{guard}',[AuthController::class,'askResetPassword']);   
Route::post('/resetPassword',[AuthController::class,'resetPassword'])->name('resetPassword');



//Student part
Route::post('/studentCreateAccount',[StudentController::class,"studentCreateAccount"]);
Route::post('/emailVerification/{token}',[StudentController::class,"emailVerification"])->name('emailVerification');
// Route::post('/displayAccount',[StudentController::class,"displayAccount"]); use getStudent from department head
Route::post('/studentResetPasword/{id}',[StudentController::class,"studentResetPasword"]);




//Super admin part
Route::post('/addDepartmentHead',[DepartmentHeadController::class,"addDepartmentHead"]);
Route::get('/displayDepartmentHeads',[DepartmentHeadController::class,"displayDepartmentHeads"]);
Route::get('/getDepartmentHead/{id}',[DepartmentHeadController::class,"getDepartmentHead"]);
Route::post('/editDepartmentHead/{id}',[DepartmentHeadController::class,"editDepartmentHead"]);
Route::delete('/deleteDepartmentHead/{id}',[DepartmentHeadController::class,"deleteDepartmentHead"]);
Route::post('/superAdminResetPasword/{id}',[SuperAdminController::class,"superAdminResetPasword"]);



// Department head part
Route::get('/displayAccountsRequests',[InternshipAccountsRequestsController::class,"displayAccountsRequests"]);
Route::get('/getAccountRequest/{id}',[InternshipAccountsRequestsController::class,"getAccountRequest"]);
Route::post('/manageAccountRequest/{id}',[InternshipAccountsRequestsController::class,"manageAccountRequest"]);

Route::post('/addStudentInfo',[StudentController::class,"addStudentInfo"]);
Route::get('/diplayStudents',[StudentController::class,"diplayStudents"]);
Route::get('/getStudent/{id}',[StudentController::class,"getStudent"]);
Route::post('/editStudentInfo/{id}',[StudentController::class,"editStudentInfo"]);
Route::delete('/deleteStudent/{id}',[StudentController::class,"deleteStudent"]);
Route::post('/departmentheadResetPasword/{id}',[DepartmentHeadController::class,"departmentheadResetPasword"]);



//Internship responsible part
Route::post('/accountRequest',[InternshipResponsibleController::class,"accountRequest"]);

Route::post('/addOffer',[InternshipOffersController::class,"addOffer"]);
Route::get('/displayOffers',[InternshipOffersController::class,"displayOffers"]);
Route::get('/selectOffer/{id}',[InternshipOffersController::class,"selectOffer"]);
Route::patch('/editOffer/{id}',[InternshipOffersController::class,"editOffer"]);
Route::delete('/deleteOffer/{id}',[InternshipOffersController::class,"deleteOffer"]);
Route::post('/responsibleResetPasword/{id}',[InternshipResponsibleController::class,"responsibleResetPasword"]);





