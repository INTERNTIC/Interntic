<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InternshipRequestResource extends JsonResource
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
        "student_id"=>$this->student_id,
        "internshipResponssible_email"=>$this->internshipResponssible_email,
        "status"=>boolval($this->status),
        "theme"=>$this->theme,
        "start_at"=>date_format(date_create($this->start_at), 'Y-m-d'),
        "end_at"=>date_format(date_create($this->end_at), 'Y-m-d'),
    ];
    }
}
