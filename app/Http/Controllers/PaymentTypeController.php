<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PaymentType;

class PaymentTypeController extends Controller
{
    function getPaymentTypes() {
        try {
            $paymentTypes = PaymentType::all();
            if (!count($paymentTypes)) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => []
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Fetched',
                'results' => $paymentTypes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function getPaymentType($id) {
        try {
            $paymentType = PaymentType::find($id);
            if ($paymentType) return response()->json([
                'status' => 200,
                'message' => 'Successfully Fetched',
                'results' => $paymentType
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => []
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function storePaymentType(Request $request) {
        try {
            $newPaymentType = new PaymentType([
                'id' => Str::uuid(),
                'name' => $request->name,
                'key_name' => $request->key_name
            ]);

            if ($newPaymentType->save()) return response()->json([
                'status' => 201,
                'message' => 'New payment type successfully saved'
            ], 201);

            return response()->json([
                'status' => 400,
                'message' => $request->name . ' totally failed'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function updatePaymentType($id, Request $request) {
        try {
            $paymentType = PaymentType::find($id);
            if (empty($paymentType)) return response()->json([
                'status' => 400,
                'message' => 'Payment type not found'
            ], 400);

            $paymentType->name = $request->name;
            $paymentType->key_name = $request->key_name;

            if ($paymentType->save()) return response()->json([
                'status' => 200,
                'message' => $request->name . ' successfully saved'
            ]);

            return response()->json([
                'status' => 400,
                'message' => $request->name . 'totally failed'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function deletePaymentType($id) {
        try {
            $paymentType = PaymentType::find($id);
            if (empty($paymentType)) return response()->json([
                'status' => 400,
                'message' => 'Payment type not found'
            ], 400);

            if ($paymentType->delete()) return response()->json([
                'status' => 200,
                'message' => 'Payment type has been deleted'
            ]);

            return response()->json([
                'status' => 400,
                'message' => 'Payment type totally failed'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
