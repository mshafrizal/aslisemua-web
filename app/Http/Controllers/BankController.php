<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Models\PaymentType;
use App\Models\PaymentTypeBank;
use Illuminate\Support\Str;
use ImageKit\ImageKit;
use Config;

class BankController extends Controller
{
    function getBanks()
    {
        try {
            $paymentTypes = PaymentType::with('bank')->get();
            if (!count($paymentTypes)) return response()->json([
                'status' => 200,
                'message' => 'No data found',
                'results' => []
            ], 200);

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully fetched',
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

    function getBanksByPaymentTypeId($paymentTypeId) {
        try {
            $banks = PaymentType::with('bank')->with(array('bank.paymentType' => function($query) use ($paymentTypeId){
                $query->where('id', $paymentTypeId);
            }))->where('id', $paymentTypeId)->get();
            if (!count($banks)) return response()->json([
                'status' => 200,
                'message' => 'No data found',
                'results' => []
            ], 200);

            return response()->json([
                'status' => 200,
                'message' => 'Data successfully fetched',
                'results' => $banks
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function storeBank(Request $request)
    {
        try {
            $newFileName = 'BANK-' . time() . '.' . $request->file->extension();

            $imageKit = new ImageKit(
                config('imagekit.IMAGEKIT_CDN_PUBLIC_KEY'),
                config('imagekit.IMAGEKIT_CDN_PRIVATE_KEY'),
                config('imagekit.IMAGEKIT_CDN_URL')
            );

            try {
                $uploadFile = $imageKit->upload(
                    array(
                        "file" => base64_encode(file_get_contents($request->file('file'))), // required
                        "fileName" => $newFileName, // required
                        'folder' => "/Banks"
                    )
                );
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong',
                    'error' => $e->getMessage()
                ], 500);
            }

            $newPaymentMethod = new Bank([
                'id' => Str::uuid(),
                'image_path' => $uploadFile->success->url,
                'image_name' => $newFileName,
                'file_id' => $uploadFile->success->fileId,
                'alt_image' => $request->alt_image,
                'key_name' => $request->key_name,
                'name' => $request->name
            ]);

            if ($newPaymentMethod->save()) {
                $relationship = new PaymentTypeBank([
                    'bank_id' => $newPaymentMethod->id,
                    'payment_type_id' => $request->payment_type_id
                ]);

                $relationship->save();

                return response()->json([
                    'status' => 201,
                    'message' => 'New bank successfully created'
                ], 201);
            }

            return response()->json([
                'status' => 400,
                'message' => 'New bank totally failed'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function deleteBank($paymentTypeId, $bankId) {
        try {
            $pivot = PaymentTypeBank::where('payment_type_id', $paymentTypeId)->where('bank_id', $bankId)->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Delete bank successfull'
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
