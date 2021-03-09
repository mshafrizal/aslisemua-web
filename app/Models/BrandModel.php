<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    use HasFactory;

    protected $table = 'brands';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $attributes = [
        'id', 'name', 'associated_product', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];
}
