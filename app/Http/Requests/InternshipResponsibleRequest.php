<?php

namespace App\Http\Requests;

use App\Models\InternshipResponsible;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InternshipResponsibleRequest extends FormRequest
{
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
    public function rules()
    {
        $internshipResponsible = $this->route('internshipResponsible') ?? new InternshipResponsible();
        // Password is not required if this is an update
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => ['required', 'unique:internship_responsibles,email,' . $internshipResponsible->id],
            'password' => [Rule::requiredIf(!$internshipResponsible->id), 'min:6'],
            'phone' => ['required', 'unique:internship_responsibles,phone,' . $internshipResponsible->id],
            'company_id' => ['required', 'exists:companies,id'],
        ];
    }
}
