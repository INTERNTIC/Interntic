<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InternshipRequestResource extends JsonResource
{
    public function getStatus($status){
            switch ($status) {
                case 0:
                return  str_replace("_", " ", "not_seen");
                case 1:
                    
                return str_replace("_", " ", "accepted_by_department_head");
                case 2:
                    
                return str_replace("_", " ", "refused_by_department_head");
                case 3:
                    
                return str_replace("_", " ", "refused_by_internship_responsible");
                case 4:
                    
                return str_replace("_", " ", "accepted_by_internship_responsible");
                case 5:                
                return str_replace("_", " ", "accepted_by_student");
            }
        
    }

    public function toArray($request)
    {
       return [
        "id"=>$this->id,
        "student_id"=>$this->student_id,
        "internshipResponsible_email"=>$this->internshipResponsible_email,
        "status"=>$this->status??0,
        "textStatus"=>$this->getStatus($this->status),
        "theme"=>$this->theme,
        "start_at"=>date_format(date_create($this->start_at), 'Y-m-d'),
        "end_at"=>date_format(date_create($this->end_at), 'Y-m-d'),
        "company_id"=>$this->company_id,
        "company"=>$this->company,
        "student"=> new StudentResource($this->student),
        "marks"=>new MarkResource($this->marks),
    ];
    }
}
