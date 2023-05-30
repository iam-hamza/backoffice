<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResellerProducrReseource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'categories' => $item->categories,
                    'description' => $item->description,
                    'brand' => $item->brand,
                    'displayImages' => json_decode($item->displayImages),
                    'hasStock' => $item->hasStock,
                    'stock' => $item->stock,
                    'price' => $item->price,
                    'name' => $item->name,
                    'sizes' => json_decode($item->sizes),
                    'sku' => json_decode($item->sku),
                    'slug' => $item->slug,
                    'currency' => $item->currency,
                    'status' => $item->status,
                    'website' => $item->website,
                ];
            }),
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