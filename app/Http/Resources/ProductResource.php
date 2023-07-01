<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'id' => @$this->id,
            'name' => @$this->name,
            'description' => @$this->description,
            'brand' => @$this->brand,
            'sizes' => @$this->sizes,
            'sku' => @$this->sku,
            'product_tag' => @$this->product_tag,
            'slug' => @$this->slug,
            'price' => @$this->price,
            'discount_price' => @$this->discount_price,
            'stock' => @$this->stock,
            'category_id' => @$this->category->name,
            'images' => ProductImagesResource::collection($this->whenLoaded('images')),
            'sub_category' => ProductSubCategoryResource::collection($this->whenLoaded('subcategories')),

        ];
    }
}
