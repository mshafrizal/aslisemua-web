<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PaymentType;
use App\Models\PaymentTypeBank;
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
        'name',
        'file_id'
    ];

    function paymentType()
    {
        return $this->belongsToMany(PaymentType::class, 'payment_types_banks');
    }

    function detail() {
        return $this->belongsToMany(PaymentTypeBank::class);
    }
}
