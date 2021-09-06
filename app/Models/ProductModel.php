<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id', 
        'name', 
        'description', 
        'created_by', 
        'updated_by', 
        'size', 
        'gender', 
        'color',
        'brand_id',
        'category_id',
        'condition',
        'detail',
        'base_price',
        'discount_price',
        'final_price',
        'image_path',
        'image_name',
        'alt_image',
        'status',
        'created_at',
        'updated_at',
        'stock',
        'slug',
        'file_id',
        'filename'
    ];

    /**
     * Get the brand that owns the ProductModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(BrandModel::class, 'brand_id', 'id');
    }

    /**
     * Get the category that owns the ProductModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id', 'id');
    }

    /**
     * Get all of the productImage for the ProductModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productImage()
    {
        return $this->hasMany(ProductImageModel::class, 'product_id', 'id');
    }
}
