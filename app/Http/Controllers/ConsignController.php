<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsignModel;
use App\Models\ConsignmentImageModel;
use Illuminate\Support\Str;
use Carbon\Carbon;
use ImageKit\ImageKit;
use Illuminate\Support\Facades\Auth;

class ConsignController extends Controller
{
    function storeConsignment(Request $request)
    {
        try {
            $customer = Auth::user()->id; // Session User id
            $consignError = [];
            $now = Carbon::now();
            if (!$this->validateConsignPayload($request)->response) $consignError[] = $this->validateConsignPayload($request)->field;

            if (count($consignError)) return response()->json([
                'status' => 400,
                'message' => implode(', ', $consignError) . ' still need to be filled',
                'data' => $this->validateConsignPayload($request)
            ], 200);

            if (!$request->hasFile('images')) return response()->json([
                'status' => 400,
                'message' => 'Images not found'
            ], 400);

            $images = $request->file('images');
            $imageKit = new ImageKit(
                config('imagekit.IMAGEKIT_CDN_PUBLIC_KEY'),
                config('imagekit.IMAGEKIT_CDN_PRIVATE_KEY'),
                config('imagekit.IMAGEKIT_CDN_URL')
            );

            $arrImages = [];
            $arrImagesUrl = [];
            $arrImageIds = [];

            foreach($images as $image) {
                $newFileName = 'CONSIGNMENT' . time() . $image->getClientOriginalName();
                try {
                    $uploadFile = $imageKit->upload(
                        array(
                            "file" => base64_encode(file_get_contents($image)), // required
                            "fileName" => $newFileName, // required
                            'folder' => "/Consignments"
                        )
                    );
                    $arrImagesUrl[] = $uploadFile->success->url;
                    $arrImageIds[] = $uploadFile->success->fileId;
                } catch (\Exception $e) {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Something Went Wrong',
                        'error' => $e->getMessage()
                    ], 500);
                }
                $arrImages[] = $newFileName;
            }

            $consignImage = [];
            $newConsignImage = [];

            $newConsign = new ConsignModel([
                'id' => Str::uuid(),
                'name' => ucwords($request->name),
                'phone' => $request->phone,
                'email' => $request->email,
                'goods_type' => ucwords($request->goods_type),
                'kondisi' => ucfirst($request->kondisi),
                'image_path' => $arrImagesUrl[0],
                'image_name' => $arrImages[0],
                'filename' => $arrImages[0],
                'file_id' => $arrImageIds[0],
                'created_at' => $now,
                'updated_at' => $now,
                'customer_id' => $customer
            ]);

            if ($newConsign->save()) {
                foreach($arrImagesUrl as $key => $imageUrl) {
                    $consignmentImage = [
                        'id' => Str::uuid(),
                        'consignment_id' => $newConsign->id,
                        'image_path' => $imageUrl,
                        'image_name' => $arrImages[$key],
                        'created_at' => $now,
                        'updated_at' => $now,
                        'filename' => $arrImages[$key],
                        'file_id' => $arrImageIds[$key]
                    ];

                    $newConsignImage[] = $consignmentImage;
                }

                ConsignmentImageModel::insert($newConsignImage);
                return response()->json([
                    'status' => 201,
                    'message' => 'Consignment created',
                ], 201);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Failed to create consignment',
                ], 400);
            }
            return response()->json($consignError);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500, 
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function getListConsignments() {
        try {
            $customer = Auth::user()->id; // Session User id

            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];

            $consignments = ConsignModel::with('consignImage')->where('customer_id', $customer)->paginate(10);
            if (!$consignments) return response()->json([
                'status' => 200,
                'message' => 'Consignments not found',
                'message' => []
            ], 200);

            return response()->json([
                'status' => 200,
                'message' => 'Fetched Successfully',
                'data' => $consignments
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500, 
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    function getAllConsignments() {
        try {
            $data = [
                'status' => 200,
                'message' => 'Fetched Successfully',
            ];

            $consignments = ConsignModel::paginate(10);
            if (!$consignments) return response()->json([
                'status' => 200,
                'message' => 'Consignments not found',
                'message' => []
            ], 200);

            return response()->json([
                'status' => 200,
                'message' => 'Fetched Successfully',
                'data' => $consignments
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500, 
                'message' => 'Something Went Wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    protected function validateConsignPayload($consign) {
        if (!$consign) return $this->outputValidation(false, (Object)[]);
        if (!$consign->name) return $this->outputValidation(false, 'name');
        if (!$consign->phone) return $this->outputValidation(false, 'phone');
        if (!$consign->email) return $this->outputValidation(false, 'email');
        if (!$consign->goods_type) return $this->outputValidation(false, 'goods_type');
        if (!$consign->kondisi) return $this->outputValidation(false, 'kondisi');
        if (!$consign->images) return $this->outputValidation(false, 'images');

        return (Object)[
            'response' => true,
            'field' => null
        ];
    }

    protected function outputValidation($return, $field) {
        return (Object)[
            'response' => $return,
            'field' => $field
        ];
    }
}
