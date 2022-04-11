<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTypeBank extends Model
{
    use HasFactory;

    protected $table = 'payment_types_banks';
    public $incrementing = false;
    protected $fillable = [
        'bank_id',
        'created_at',
        'updated_at',
        'payment_type_id',
    ];
}
