<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id, 
            "the_date"=>$this->the_date,
            "enter_time"=>$this->enter_time, 
            "left_time"=>$this->left_time, 
            "note"=>$this->note, 
            "internship_request_id"=>$this->internship_request_id,
            "internship_request"=>new InternshipRequestResource($this->internship_request),
            
        ];
    }
}
