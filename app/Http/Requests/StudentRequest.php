<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
    public function attributes(): array
    {
        return [
            'phone' => 'phone number',
            'student_card' => 'student card number',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        // $student= new Student();
        $student = $this->route('student') ?? new Student();
        return [
                'first_name'=>'required',
                'last_name'=>'required',
                'birthday'=>['required',"date"],
                'place_of_birth'=>'required',
                'phone'=>['required','numeric','unique:students,phone,'.$student->id],
                'student_card'=>'required',
                'social_security_num'=>'required',
                'level_id'=>['required','exists:levels,id'],
                'major_id'=>['required','exists:majors,id'],
            ];
    }
}
