<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'image_path',
        'image_name',
        'created_at',
        'updated_at',
        'alt_image',
        'notes',
        'description',
        'cta_name',
        'cta_url',
        'title',
        'file_id',
        'slug',
        'section',
        'position',
        'play_speed',
        'status',
        'background'
    ];
}
