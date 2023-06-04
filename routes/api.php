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
use App\Http\Controllers\DepartmentController;
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
// not Auth routes 
Route::post('/studentCreateAccount', [StudentController::class, "studentCreateAccount"]);
Route::get('/emailVerification/{token}', [StudentController::class, "emailVerification"])->name('emailVerification');



//Authentication part
Route::controller(AuthController::class)->group(function () {
    Route::post('/login/{guard}', "login");
    Route::group(['middleware' => 'check.auth.guard'], function () {
        Route::get('/getUserByToken', "getUserByToken");
        Route::post('/logout', "logout");
        Route::patch('/update-password', "updatePassword");
    });
    Route::post('/forgetPassword/{guard}', 'forgetPassword');
    Route::patch('/resetPassword', 'resetPassword')->name('resetPassword');
   
});
Route::group(['middleware' => 'check.auth.guard'], function () {
    //Student part
    // Route::post('/displayAccount',[StudentController::class,"displayAccount"]); use getStudent from department head
    Route::post('/studentResetPasword/{id}', [StudentController::class, "studentResetPasword"]);
    Route::group(['middleware' => 'check.auth.guard'], function () {
        Route::apiResource('internshipRequests', InternshipRequestController::class);
    });

    //Super admin part
    // department_heads 
    Route::apiResource('department-heads', DepartmentHeadController::class);
    Route::apiResource('super-admins', SuperAdminController::class);
    Route::apiResource('departments', DepartmentController::class);


    // Department head part
    Route::get('/displayAccountsRequests', [InternshipAccountsRequestsController::class, "displayAccountsRequests"]);
    Route::get('/getAccountRequest/{id}', [InternshipAccountsRequestsController::class, "getAccountRequest"]);
    Route::post('/manageAccountRequest/{id}', [InternshipAccountsRequestsController::class, "manageAccountRequest"]);

    Route::post('/addStudentInfo', [StudentController::class, "addStudentInfo"]);
    Route::get('/displayStudents', [StudentController::class, "diplayStudents"]);
    Route::get('/getStudent/{student}', [StudentController::class, "getStudent"]);
    Route::patch('/editStudentInfo/{student}', [StudentController::class, "editStudentInfo"]);
    Route::delete('/deleteStudent/{student}', [StudentController::class, "deleteStudent"]);
    // Route::post('/departmentheadResetPasword/{department_head}', [DepartmentHeadController::class, "departmentheadResetPasword"]);





    //Internship responsible part
    Route::post('/accountRequest', [InternshipResponsibleController::class, "accountRequest"]);

    Route::apiResource('internshipResponsibles', InternshipResponsibleController::class);

    Route::get('/displayOffers', [InternshipOffersController::class, "displayOffers"]);
    Route::post('/addOffer', [InternshipOffersController::class, "addOffer"]);
    Route::get('/selectOffer/{offer}', [InternshipOffersController::class, "selectOffer"]);
    Route::patch('/editOffer/{offer}', [InternshipOffersController::class, "editOffer"]);
    Route::delete('/deleteOffer/{offer}', [InternshipOffersController::class, "deleteOffer"]);
    // Route::post('/responsibleResetPassword/{id}', [InternshipResponsibleController::class, "responsibleResetPasword"]);


    Route::apiResource('companyCauses', CompanyCauseController::class,  ['only' => ['index', 'store','update','destroy']]);
    Route::apiResource('companyRefuses', CompanyRefuseController::class,  ['only' => ['index', 'store', 'show', 'destroy']]);
    Route::apiResource('departmentRefuses', DepartmentRefuseController::class,  ['only' => ['index', 'store', 'show', 'destroy']]);
    Route::apiResource('departmentCauses', DepartmentCauseController::class,  ['only' => ['index', 'store','update', 'destroy']]);
    Route::get('departmentCauses/get_all',[DepartmentCauseController::class,"get_all"  ]);
    Route::get('companyCauses/get_all',[CompanyCauseController::class,"get_all"  ]);


    Route::get('/levels/majors/{level}', [LevelController::class, "getMajors"]);
    Route::apiResource('levels', LevelController::class);
    Route::apiResource('majors', MajorController::class);
    Route::apiResource('companies', CompanyController::class);
    Route::get('studentCvItems/{student}', [StudentCvItemController::class,"index"]);
    Route::apiResource('studentCvItems', StudentCvItemController::class);
    Route::get('/marks/generate-pdf/{internshipRequest}', [InternshipRequestController::class, "getPDF"]);
    Route::apiResource('marks', MarkController::class);
    

    Route::post('/internshipRequests/manage/{internshipRequest}', [InternshipRequestController::class, "manageTheInternshipRequest"]);
    Route::get('/internships/accepted-by-internship-responsible', [InternshipRequestController::class, "internshipsAcceptedByInternshipResponsible"]);
    Route::get('/internships/accepted-by-department-head', [InternshipRequestController::class, "internshipsIAcceptedByDepartmentHead"]);
    Route::get('/internships/accepted-by-student', [InternshipRequestController::class, "internshipsIAcceptedByStudent"]);
    Route::get('/internships/refused', [InternshipRequestController::class, "refusedInternships"]);
    Route::get('/internships/students/not-assessed', [InternshipRequestController::class, "studentInternshipsNotAssessedToday"]);
    Route::get('/internships/passed', [InternshipRequestController::class, "myPassedInternships"]);
    Route::post('/internships/accept/{internshipRequest}', [InternshipRequestController::class, "accept_my_internship"]);

    Route::apiResource('accountRequests', AccountRequestController::class, ['only' => ['index','show', 'destroy']]);
    Route::post('accountRequests/manage/{accountRequest}', [AccountRequestController::class,'manageAccountRequest']);

    Route::apiResource('assessments',AssessmentController::class);
    Route::get('assessments/{internship_request_id}/all',[AssessmentController::class,'assessmentsOfInternship']);
});
// store method shold br without auth
Route::post('accountRequests', [AccountRequestController::class,'store']);

// Route::get('/level_majors',[LevelMajorController::class,"manageTheInternshipRequest"]);
