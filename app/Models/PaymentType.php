<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bank;

class PaymentType extends Model
{
    use HasFactory;

    protected $table = 'payment_types';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'key_name',
        'name'
    ];

    function bank() {
        return $this->belongsToMany(Bank::class, 'payment_types_banks');
    }
}
