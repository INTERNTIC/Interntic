<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'id'=>$this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email'=> isset($this->student_account)?$this->student_account->email:null,
            'birthday' => date_format(date_create($this->birthday), 'Y-m-d'),
            'place_of_birth' => $this->place_of_birth,
            'phone_number' => $this->phone,
            'student_card_number' => $this->student_card,
            'social_security_num' => $this->social_security_num,
            'level' => $this->level_major->level->name,
            'major' => $this->level_major->major->name,
            'level_id' => strval($this->level_major->level->id),
            'major_id' => strval($this->level_major->major->id),
            'guard' => 'student',
        ];
    }
}
