<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $table = 'customer_addresses';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'customer_id',
        'name',
        'phone',
        'is_default',
        'address'
    ];

    /**
     * Get the customer that owns the CustomerAddress
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
