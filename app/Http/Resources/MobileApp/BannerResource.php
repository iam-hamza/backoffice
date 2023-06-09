<?php

namespace App\Http\Resources\MobileApp;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
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
            'id' => $this->id,
            'banner_type' => $this->banner_type,
            'image' => $this->image,
            'title' => $this->title,
            'body' => $this->body,
        ];
    }
}
