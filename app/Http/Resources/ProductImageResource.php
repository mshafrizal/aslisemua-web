<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        $product = $this->whenLoaded('product');
        return [
            'id' => $this->id,
            'image_path' => $this->image_path,
            'image_name' => $this->image_name,
            'product_id' => $this->product_id,
            'product' => new ProductResource($product),
            // 'further_subcategories' => FurtherSubCategoryResource::collection($this->whenLoaded('furtherSubCategory'))
        ];
    }
}
