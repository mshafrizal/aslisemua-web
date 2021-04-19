<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $brand = $this->whenLoaded('brand');
        $category = $this->whenLoaded('category');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'base_price' => $this->base_price,
            'discount_price' => $this->discount_price,
            'brand' => new BrandResource($brand),
            'category' => new CategoryResource($category),
        ];
    }
}
