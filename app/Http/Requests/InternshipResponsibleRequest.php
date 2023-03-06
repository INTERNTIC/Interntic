<?php

namespace App\Http\Requests;

use App\Models\InternshipResponsible;
use Illuminate\Foundation\Http\FormRequest;

class InternshipResponsibleRequest extends FormRequest
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
    ];
}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $internshipResponsible=$this->route('internshipResponsible')?? new InternshipResponsible();
        // TO DO  update password problem
        return [
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>['required','unique:account_requests,email,'.$internshipResponsible->email],
            'password'=>['required','min:6'],
            'phone'=>'required',
            'company_id'=>['required','exists:companies,id'],
        ];
    }
}
