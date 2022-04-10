<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'order_id',
        
        // Person in Charge
        'billing_name',
        'billing_email',
        'billing_phone_number',
        'billing_zip_code',
        'billing_address',
        'billing_city',
        'billing_district',

        // Receiver
        'shipping_name',
        'shipping_phone_number',
        'shipping_zip_code',
        'shipping_address',
        'shipping_city',
        'shipping_district',

        'created_at',
        'updated_at',
        'requested_at',
        'requested_by',
        'canceled_at',
        'canceled_by',
        'expired_at',
        'delivered_at',
        'delivered_by',
        'finished_at',
        'finished_by',
        'note',
        'payment_type',
        'payment_method',
        'payment_status',
        'order_status',
        'shipping_status',
        'delivery_at',
        'delivery_by',
        'paid_at',
        'paid_by',
        'processed_by',
        'processed_at',
        'pending_at',
        'is_installment',
        'total_installment',
        'total_base_price',
        'discount_price',
        'total_final_price',
        'handling_fee',
        'snap_token',
    ];

    public function orderHistory() {
        return $this->hasMany('App\Models\OrderHistory', 'order_id', 'order_id');
    }

    public function orderItem() {
        return $this->hasMany('App\Models\OrderDetail', 'order_id', 'order_id');
    }
}