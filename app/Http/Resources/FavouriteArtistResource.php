<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteArtistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return $request;
        $a=$this->parposal->job->toArray();
        return[
            'id' => (string)$this->id,
            'amount'=>$this->parposal->budget,
            'order_status'=>   $this->order_status_name,
            'payment_status'=>   $this->payment_status_name,
            'job'=>[
                'id'=>$this->parposal->job->id,
                'uid'=>$this->parposal->job->uid,
                'job_title' => $this->parposal->job->title,   
                'city' => $this->parposal->job->city_name,
                'description' => $this->parposal->job->description,

            ],
            'date'=>[
                'date'=>$this->parposal->job->event->date_time, 
            ],
            'type'=>[
                'type'=>$this->parposal->job->type->name, 
            ],
            'service'=>[ 
                'job_service'=>$a['job_service'], 
            ],
            'artist'=>[
                'artist_id'=>$this->parposal->artist->id,
                'user_id'=>$this->parposal->artist->user_id,
                'name'=>$this->parposal->artist->users->full_name,
            ],
            'customer'=>[
                'user_id' => $this->parposal->job->customer->id,   
                'name' => $this->parposal->job->customer->full_name,   
            ],
            'parposal_count'=>[
                'parposal_count' => $this->parposal->job->job_proposal_count,  
            ],
        ];
    }
}
