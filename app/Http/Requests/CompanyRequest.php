<?php

namespace App\Http\Requests;
use App\Models\Company;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
        $company=$this->route('company')?? new Company();
        return [
        'name'=>['required'],
        'location'=>['required',
        Rule::unique("companies")->where(
            function ($query) use ($company) {
                return $query->where(
                    [
                        ["name", "=", $company->name],
                        ["location", "=", $company->location]
                    ]
                );
            })->ignore($company->id)
        ]
        ];
    }
}
