<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'product_name',
        'size',
        'color',
        'gender',
        'brand_id',
        'brand_name',
        'category_id',
        'category_name',
        'base_price',
        'discount_price',
        'final_price',
        'image_path',
        'image_name',
        'alt_image',
        'created_at',
        'updated_at',
    ];
}
