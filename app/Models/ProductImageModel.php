<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ProductModel;

class ProductImageModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'products_images';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'product_id',
        'image_path',
        'image_name',
        'created_at',
        'updated_at',
        'file_id',
        'filename'
    ];

    /**
     * Get the brand that owns the ProductModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }
}
