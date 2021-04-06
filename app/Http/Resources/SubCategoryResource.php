<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $categories = $this->whenLoaded('category');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'file_path' => $this->file_path,
            'parent' => $this->parent,
            'is_published' => $this->is_published,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category' => new CategoryResource($categories),
            'further_subcategories' => FurtherSubCategoryResource::collection($this->whenLoaded('furtherSubCategory'))
        ];
    }
}
