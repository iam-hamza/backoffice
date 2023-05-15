<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[ 
            'uid'=>$this->job->uid,
            'name'=>$this->reviewer->full_name,
            'review'=>$this->review,
            'rating'=>$this->rating,
            'date'=>$this->created_at->format('F d Y'),
        ];
    }
}
