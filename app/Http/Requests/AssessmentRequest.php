<?php

namespace App\Http\Requests;

use App\Models\Assessment;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AssessmentRequest extends FormRequest
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

    public function rules()
    {

        $assessment = $this->route('assessment') ?? new Assessment();
        return [
            'the_date' => [
                'required', 'date',
                Rule::unique("assessments")->where(
                    function ($query) {
                        return $query->where(
                            [
                                ["the_date", "=", $this->the_date],
                                ["internship_request_id", "=", $this->internship_request_id],
                            ]
                        );
                    }
                )->ignore($assessment->id)
            ],
            'enter_time' => ['nullable', 'date_format:H:i:s'],
            'left_time' => ['nullable', 'date_format:H:i:s'],
            'note' => ['nullable'],
            'internship_request_id' => ['required', 'exists:internship_requests,id']
        ];
    }
}
