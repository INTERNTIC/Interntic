<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
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
        'theme'=>$this->theme,
		'details'=>$this->details,
		'duration'=>$this->duration,
		'internship_responsible_id'=>$this->internship_responsible_id,
        'internship_responsible'=>$this->internship_responsible
        ];
    }
}
