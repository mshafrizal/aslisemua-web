<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsignModel extends Model
{
    use HasFactory;

    protected $table = 'consignments';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
        'phone',
        'email',
        'goods_type',
        'kondisi',
        'image_path',
        'image_name',
        'filename',
        'file_id',
        'created_at',
        'updated_at',
        'customer_id'
    ];
}
