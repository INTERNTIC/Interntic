<?php

use App\Models\InternshipRequest;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::view('/reset-password', 'welcome')->name('resetPassword.index');
Route::get('/pdf',function(){
    $internshipRequest=InternshipRequest::find(6);
    $student = $internshipRequest->student;
    // $internship_responsible = $internshipRequest->internship_responsible();
    $data = [
        "student_full_name" => $student->first_name . " " . $student->last_name,
        "birthday" => date_format(date_create($student->birthday), 'Y-m-d'),
        "place_of_birth" => $student->place_of_birth,
        "duration" => "12 days",
        "company_name" => $internshipRequest->company->name . " " . $internshipRequest->company->location,
        "end_date" => date_format(date_create($internshipRequest->end_at), 'Y-m-d'),
        "internship_responsible_full_name" => "internship_responsible_full_name",
        // "internship_responsible_full_name" => $internship_responsible->first_name . " " . $internship_responsible->last_name,
    ];
    return view('certeficate.certaficate',$data);
});

Route::view('{any}', 'welcome')->where('any','^(?!api/).*');