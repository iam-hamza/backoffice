<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductBackOfficeResource extends JsonResource
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
            'reseller_product_id' => $this->reseller_product_id,
            'name' => $this->name,
            'description' => $this->description,
            'brand' => $this->brand,
            'sizes' => json_decode(str_replace("'", '"',$this->sizes)),
            'sku' => $this->sku,
            'product_tag' => json_decode($this->product_tag),
            'slug' => $this->slug,
            'hasStock' => $this->hasStock,
            'profit_margin' => $this->profit_margin,
            'price' => $this->price,
            'discount' => $this->discount,
            'discount_price' => $this->discount_price,
            'resaler_price' => $this->resaler_price,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
            'deleted_at' => $this->deleted_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'is_showroom' => $this->is_showroom,
            'category' => $this->category,
            'sub_category'  => $this->subcategories,
            'images'    => $this->images,
            // 'pagination' => [
            //     'total' => @$this->total(),
            //     'per_page' => @$this->perPage(),
            //     'current_page' => @$this->currentPage(),
            //     'last_page' => @$this->lastPage(),
            //     'from' => @$this->firstItem(),
            //     'to' => @$this->lastItem(),
            // ],
        ];
        
    }
}
