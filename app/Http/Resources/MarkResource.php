<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarkResource extends JsonResource
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
            "discipline"=>$this->discipline,
            "skills"=>$this->skills,
            "initiative"=>$this->initiative,
            "creativity"=>$this->creativity,
            "knowledge"=>$this->knowledge,
            "internship_request_id"=>$this->internship_request_id,
            // "internship_request"=>new InternshipRequestResource($this->internship_request),

        ];
    }
}
