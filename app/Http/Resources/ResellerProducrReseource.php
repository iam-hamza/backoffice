<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResellerProducrReseource extends JsonResource
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
                    'displayImages' => json_decode($this->displayImages),
                    'hasStock' => $this->hasStock,
                    'stock' => $this->stock,
                    'price' => $this->price,
                    'name' => $this->name,
                    'sizes' => json_decode($this->sizes),
                    'sku' => json_decode($this->sku),
                    'slug' => $this->slug,
                    'currency' => $this->currency,
                    'status' => $this->status,
                    'website' => $this->website,
                    'pagination' => [
                        'total' => $this->total(),
                        'per_page' => $this->perPage(),
                        'current_page' => $this->currentPage(),
                        'last_page' => $this->lastPage(),
                        'from' => $this->firstItem(),
                        'to' => $this->lastItem(),
                    ],
        ];
        
    }
}
