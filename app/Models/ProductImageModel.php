<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImageModel extends Model
{
    use HasFactory;

    protected $table = 'products_images';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'product_id',
        'image_path',
        'image_name',
        'created_at',
        'updated_at'
    ];
}
