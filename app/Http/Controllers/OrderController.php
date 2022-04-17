<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Notification;

class OrderController extends Controller
{
    function callbackNotificationPG() {
        $notif = new Notification();
        $transactionStatus = $notif->transaction_status;
        $fraudStatus = $notif->fraud_status;
        $orderId = $notif->order_id;
        error_log("Order ID $orderId: "."transaction status = $transactionStatus, fraud staus = $fraudStatus");

        if ($transaction == 'capture') {
            if ($fraud == 'challenge') {
              // TODO Set payment status in merchant's database to 'challenge'
            }
            else if ($fraud == 'accept') {
              // TODO Set payment status in merchant's database to 'success'
            }
        }
        else if ($transaction == 'cancel') {
            if ($fraud == 'challenge') {
              // TODO Set payment status in merchant's database to 'failure'
            }
            else if ($fraud == 'accept') {
              // TODO Set payment status in merchant's database to 'failure'
            }
        }
        else if ($transaction == 'deny') {
            // TODO Set payment status in merchant's database to 'failure'
        }
    }

    static function changeStatus($orderId, $status) {

    }
}
