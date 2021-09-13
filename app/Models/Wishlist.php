<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductModel;

class Wishlist extends Model
{
    use HasFactory;
    
    protected $table = 'wishlists';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id', 
        'product_id', 
        'customer_id', 
        'created_at',
        'is_selected'
    ];

    /**
     * Get all of the product for the Wishlist
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function product()
    {
        return $this->belongsTo(ProductModel::class);
    }
}
