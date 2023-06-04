<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentCvItemResource extends JsonResource
{
    
    public function toArray($request)
    {
        // $addedData=['student'=>$this->student];

        return array_merge(parent::toArray($request));
    }
}
