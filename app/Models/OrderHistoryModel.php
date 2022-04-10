<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistoryModel extends Model
{
    use HasFactory;

    protected $table = 'order_histories';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'order_id',
        'title',
        'description',
        'status',
        'created_at',
        'updated_at',
    ];

    public function order() {
        return $this->belongsTo('App\Models\OrderModel', 'order_id');
    }
}
