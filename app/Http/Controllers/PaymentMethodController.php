<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    function getPaymentMethods() {
        try {
            $paymentMethod = PaymentMethod::all();
            if (!$paymentMethod) return response()->json([
                'status' => 200,
                'message' => 'No Data found',
                'results' => []
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Successfully Fetched',
                'results' => $paymentMethod
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function deletePaymentMethod($id) {
        try {
            $paymentMethodExisting = PaymentMethod::find($id);
            if (empty($paymentMethodExisting)) return response()->json([
                'status' => 400,
                'message' => 'Payment Method not found'
            ], 400);

            $oldFilePath = $paymentMethodExisting->image_path;
            if ($paymentMethodExisting->delete()) {
                $paymentMethodPrefix = 'paymentmethods/';
                $prefixLength = strlen($paymentMethodPrefix);
                $oldFileName = '';
                if (substr($oldFilePath, 0, $prefixLength) === $paymentMethodPrefix) {
                    $oldFileName = substr($oldFilePath, $prefixLength);
                    $this->unlinkImage($oldFileName);
                }

                return response()->json([
                    'status' => 200,
                    'message' => $paymentMethodExisting->alt_image . ' successfully deleted'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function createPaymentMethod(Request $request) {
        try {
            $newFileName = 'PAYMENTMETHOD-' . time() . '.' .$request->file->extension();
            $newPaymentMethod = new PaymentMethod([
                'id' => Str::uuid(),
                'alt_image' => $request->alt_image,
                'image_path' => $request->file('file')->storeAs('paymentmethods', $newFileName, 'public'),
                'image_name' => $newFileName
            ]);

            if ($newPaymentMethod->save()) return response()->json([
                'status' => 201,
                'message' => 'New payment method successfully created'
            ], 201);

            $this->unlinkImage($newFileName);
            return response()->json([
                'status' => 400,
                'message' => 'New payment method totally failed'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function unlinkImage ($fileName) {
        Storage::delete('/public/paymentmethods/' . $fileName);
    }
}
