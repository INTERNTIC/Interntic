<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class InternshipRequest_Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $student_id = JWTAuth::parseToken()->authenticate()->id;
        $this->merge(['student_id' => $student_id]);
        return [
		'internshipResponssible_email'=>['required', 'email'],
		'theme'=>['required', 'string'],
        'status'=>['boolean'],
		'start_at'=>['required','date','before:end_at' ],
		'end_at'=>['required','date','after:start_at'],
        'student_id'=>['required'],
        'company_name'=>['required'],
        'company_location'=>['required']
        ];
    }
}
