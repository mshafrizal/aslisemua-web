<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'banks';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id', 
        'image_path', 
        'image_name', 
        'created_at',
        'updated_at',
        'alt_image',
        'key_name',
        'name'
    ];

}
