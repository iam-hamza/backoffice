<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleProductResource extends JsonResource
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
            'categories' => $this->categories,
            'description' => $this->description,
            'brand' => $this->brand,
            'displayImages' => json_decode(str_replace("'", '"',$this->displayImages)),
            'hasStock' => $this->hasStock,
            'stock' => $this->stock,
            'price' => $this->price,
            'name' => $this->name,
            'sizes' => $this->sizes,
            'sku' => $this->sku,
            'slug' => $this->slug,
            'currency' => $this->currency,
            'status' => $this->status,
            'website' => $this->website,
        ];
    }
}
