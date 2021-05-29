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
            'final_price' => $this->final_price,
            'base_price' => $this->base_price,
            'discount_price' => $this->discount_price,
            'size' => $this->size,
            'gender' => $this->gender,
            'color' => $this->color,
            'condition' => $this->condition,
            'description' => $this->description,
            'detail' => $this->detail,
            'slug' => $this->slug,
            'alt_image' => $this->alt_image,
            'status' => $this->status,
            'stock' => $this->stock,
            'brand' => new BrandResource($brand),
            'category' => new CategoryResource($category),
            'products_images' => ProductImageResource::collection($this->whenLoaded('productImage'))
        ];
    }
}
