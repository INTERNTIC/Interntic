<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest_Request extends FormRequest
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
        return [
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>['required','unique:account_requests'],
            'password'=>['required','min:6',"confirmed"],
            'phone'=>['required','numeric'],
            'company_name'=>'required',
            'company_location'=>'required',
        ];
    }
}
