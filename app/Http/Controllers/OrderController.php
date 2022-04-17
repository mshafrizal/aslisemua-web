<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans;
use App\Models\Order;
use App\Models\OrderHistoryModel;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    function callbackNotificationPG(Request $request) {
        try {
            $transactionStatus = $request->transaction_status;
            $fraudStatus = $request->fraud_status;
            $orderId = $request->order_id;

            // Update transaction status
            $order = Order::where('order_id', $orderId)->first();

            if ($transactionStatus == 'capture') {
                // For credit card transaction, we need to check whether transaction is challenge by FDS or not
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->payment_status = 'pending';
                        $order->order_status = 'pending';
                        $order->shipping_status = 'pending';
                        $order->pending_at = now();

                        if ($order->save()) {
                            // Save order history
                            $orderHistory = [
                                'id' => Str::uuid(),
                                'order_id' => $orderId,
                                'status' => 'processed',
                                'created_at' => now(),
                                'updated_at' => now(),
                                'title' => 'Pesanan tertunda',
                                'description' => 'Maaf pesanannya tertunda',
                            ];
                            OrderHistoryModel::create($orderHistory);
                        }
                    } else {
                        $order->payment_status = 'paid';
                        $order->paid_at = $request->settlement_time;
                        $order->paid_by = 'midtrans';
                        $order->order_status = 'processed';
                        $order->processed_at = now();
                        $order->processed_by = 'system';
                        $order->snap_token = null;
                        $order->shipping_status = 'processed';
                        $order->pending_at = null;

                        if ($order->save()) {
                            // Save order history
                            $orderHistory = [
                                'id' => Str::uuid(),
                                'order_id' => $orderId,
                                'status' => 'processed',
                                'created_at' => now(),
                                'updated_at' => now(),
                                'title' => 'Pesanan diproses',
                                'description' => 'Pesanan sedang diproses oleh kami',
                            ];
                            OrderHistoryModel::create($orderHistory);
                        }
                    }
                }
            } else if ($transactionStatus == 'settlement') {
                $order->payment_status = 'paid';
                $order->paid_at = $request->settlement_time;
                $order->paid_by = 'midtrans';
                $order->order_status = 'processed';
                $order->processed_at = now();
                $order->processed_by = 'system';
                $order->snap_token = null;
                $order->shipping_status = 'processed';
                $order->pending_at = null;
                if ($order->save()) {
                    // Save order history
                    $orderHistory = [
                        'id' => Str::uuid(),
                        'order_id' => $orderId,
                        'status' => 'processed',
                        'created_at' => now(),
                        'updated_at' => now(),
                        'title' => 'Pesanan diproses',
                        'description' => 'Pesanan sedang diproses oleh kami',
                    ];
                    OrderHistoryModel::create($orderHistory);
                }
            } else if (
                $transactionStatus == 'cancel' 
                || $transactionStatus == 'expire' 
                || $transactionStatus == 'deny'
            ) {
                $order->order_status = 'cancelled';
                $order->payment_status = 'cancelled';
                $order->shipping_status = 'cancelled';
                $order->snap_token = null;
                $order->canceled_at = now();
                $order->canceled_by = 'system';

                if ($transactionStatus == 'expire') $order->expired_at = now();

                // Status history
                $status = 'cancelled';
                if ($transactionStatus === 'expire') $status = 'expired';
                else if ($transactionStatus === 'deny') $status = 'denied';

                // Message history
                $message = 'Pesanan dibatalkan';
                if ($transactionStatus === 'expire') $message = 'Pembayaran pesanan telah kadaluarsa';
                else if ($transactionStatus === 'deny') $message = 'Pesanan ditolak';

                // Notes history
                $notes = 'Maaf pesanan dibatalkan';
                if ($transactionStatus === 'expire') $notes = 'Maaf pembayaran pesanan telah kadaluarsa';
                else if ($transactionStatus === 'deny') $notes = 'Maaf pesanan ditolak';

                // Save order history
                $orderHistory = [
                    'id' => Str::uuid(),
                    'order_id' => $orderId,
                    'status' => $status,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'title' => $message,
                    'description' => $notes,
                ];
                OrderHistoryModel::create($orderHistory);
            }

            // TODO: 
            // 1. Add payment_type_string, transaction_id, json_from_payment_gateway
            // 2. Add payment history
        } catch (Exception $e) {
            error_log("Error in Processing Notification");
            echo $e->getMessage();
        }
    }

    static function changeStatus() {

    }
}
