<?php


use App\Models\DepartmentCause;
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
Route::get('/home', function () {
    return view('home');
});
Route::view('/reset-password', 'welcome')->name('resetPassword.index');
// TODO fix RefusedInternshipRequest_department

Route::get('/test',function(){
    
    $data = [
        "internship_request"=>InternshipRequest::find(3),
    ];
    return view('StudentValidateInternship',$data);
});

Route::view('{any}', 'welcome')->where('any','^(?!api/).*');