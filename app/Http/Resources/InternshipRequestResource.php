<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InternshipRequestResource extends JsonResource
{
    // TODO create function that show status as in config 

    public function toArray($request)
    {
       return [
        "id"=>$this->id,
        "student_id"=>$this->student_id,
        "internshipResponsible_email"=>$this->internshipResponsible_email,
        "status"=>$this->status,
        "theme"=>$this->theme,
        "start_at"=>date_format(date_create($this->start_at), 'Y-m-d'),
        "end_at"=>date_format(date_create($this->end_at), 'Y-m-d'),
        "company"=>$this->company,
        "student"=> new StudentResource($this->student) ,
    ];
    }
}
