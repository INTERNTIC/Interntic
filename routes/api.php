<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\SuperAdminController;

use App\Http\Controllers\CompanyCauseController;
use App\Http\Controllers\CompanyRefuseController;
use App\Http\Controllers\StudentCvItemController;
use App\Http\Controllers\AccountRequestController;
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\DepartmentCauseController;
use App\Http\Controllers\DepartmentRefuseController;
use App\Http\Controllers\InternshipOffersController;
use App\Http\Controllers\InternshipRequestController;
use App\Http\Controllers\InternshipResponsibleController;
use App\Http\Controllers\InternshipAccountsRequestsController;



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
Route::controller(AuthController::class)->group(function () {
    Route::post('/login/{guard}', "login");
    Route::group(['middleware' => 'check.auth.guard'], function () {
        Route::get('/getUserByToken', "getUserByToken");
        Route::post('/logout', "logout");
    });
    Route::post('/askResetPassword/{guard}', 'askResetPassword');
    Route::post('/resetPassword', 'resetPassword')->name('resetPassword');
});
Route::group(['middleware' => 'check.auth.guard'], function () {
    //Student part
    Route::post('/studentCreateAccount', [StudentController::class, "studentCreateAccount"]);
    Route::post('/emailVerification/{token}', [StudentController::class, "emailVerification"])->name('emailVerification');
    // Route::post('/displayAccount',[StudentController::class,"displayAccount"]); use getStudent from department head
    Route::post('/studentResetPasword/{id}', [StudentController::class, "studentResetPasword"]);
    Route::group(['middleware' => 'check.auth.guard'], function () {
        Route::apiResource('internshipRequests', InternshipRequestController::class);
    });

    //Super admin part
    Route::post('/addDepartmentHead', [DepartmentHeadController::class, "addDepartmentHead"]);
    Route::get('/displayDepartmentHeads', [DepartmentHeadController::class, "displayDepartmentHeads"]);
    Route::get('/getDepartmentHead/{id}', [DepartmentHeadController::class, "getDepartmentHead"]);
    Route::post('/editDepartmentHead/{id}', [DepartmentHeadController::class, "editDepartmentHead"]);
    Route::delete('/deleteDepartmentHead/{id}', [DepartmentHeadController::class, "deleteDepartmentHead"]);
    Route::post('/superAdminResetPasword/{id}', [SuperAdminController::class, "superAdminResetPasword"]);



    // Department head part
    Route::get('/displayAccountsRequests', [InternshipAccountsRequestsController::class, "displayAccountsRequests"]);
    Route::get('/getAccountRequest/{id}', [InternshipAccountsRequestsController::class, "getAccountRequest"]);
    Route::post('/manageAccountRequest/{id}', [InternshipAccountsRequestsController::class, "manageAccountRequest"]);

    Route::post('/addStudentInfo', [StudentController::class, "addStudentInfo"]);
    Route::get('/displayStudents', [StudentController::class, "diplayStudents"]);
    Route::get('/getStudent/{id}', [StudentController::class, "getStudent"]);
    Route::patch('/editStudentInfo/{id}', [StudentController::class, "editStudentInfo"]);
    Route::delete('/deleteStudent/{id}', [StudentController::class, "deleteStudent"]);
    Route::post('/departmentheadResetPasword/{id}', [DepartmentHeadController::class, "departmentheadResetPasword"]);





    //Internship responsible part
    Route::post('/accountRequest', [InternshipResponsibleController::class, "accountRequest"]);

    Route::apiResource('internshipResponsibles', InternshipResponsibleController::class);

    Route::get('/displayOffers', [InternshipOffersController::class, "displayOffers"]);
    Route::post('/addOffer', [InternshipOffersController::class, "addOffer"]);
    Route::get('/selectOffer/{offer}', [InternshipOffersController::class, "selectOffer"]);
    Route::patch('/editOffer/{offer}', [InternshipOffersController::class, "editOffer"]);
    Route::delete('/deleteOffer/{offer}', [InternshipOffersController::class, "deleteOffer"]);
    Route::post('/responsibleResetPassword/{id}', [InternshipResponsibleController::class, "responsibleResetPasword"]);




    // u shold be auth
    // TODO try defult auth middleware
    // TODO cv fix model and db
    // short_cut at depremtent unique
    Route::apiResource('companyCauses', CompanyCauseController::class,  ['only' => ['index', 'store', 'destroy']]);
    Route::apiResource('companyRefuses', CompanyRefuseController::class,  ['only' => ['index', 'store', 'show', 'destroy']]);
    Route::apiResource('departmentRefuses', DepartmentRefuseController::class,  ['only' => ['index', 'store', 'show', 'destroy']]);
    Route::apiResource('departmentCauses', DepartmentCauseController::class,  ['only' => ['index', 'store', 'destroy']]);


    Route::get('/levels/majors/{level}', [LevelController::class, "getMajors"]);
    Route::apiResource('levels', LevelController::class);
    Route::apiResource('majors', MajorController::class);
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('studentCvItems', StudentCvItemController::class);
    Route::apiResource('marks', MarkController::class);

    Route::post('/internshipRequests/manage/{internshipRequest}', [InternshipRequestController::class, "manageTheInternshipRequest"]);
    Route::get('/internships/students/', [InternshipRequestController::class, "internshipsIAccepted"]);
    Route::get('/internships/students/not-assessed', [InternshipRequestController::class, "studentInternshipsNotAssessedToday"]);

    Route::apiResource('accountRequests', AccountRequestController::class, ['only' => ['index','show', 'destroy']]);
    Route::post('accountRequests/manage/{accountRequest}', [AccountRequestController::class,'manageAccountRequest']);

    Route::apiResource('assessments',AssessmentController::class);
    Route::get('assessments/{internship_request_id}/all',[AssessmentController::class,'assessmentsOfInternship']);
});
// store method shold br without auth
Route::post('accountRequests', [AccountRequestController::class,'store']);

// Route::get('/level_majors',[LevelMajorController::class,"manageTheInternshipRequest"]);

// TODO add company id to company causes table