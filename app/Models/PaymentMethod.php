<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id', 
        'image_path', 
        'image_name', 
        'created_at',
        'updated_at',
        'alt_image'
    ];

}
