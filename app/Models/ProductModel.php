<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
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
        'updated_at'
    ];
}
