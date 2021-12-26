<?php

namespace App\Http\Controllers;

use App\Models\RegionProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class RegionProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            return response()->json([
                'status' => 200,
                'message' => 'Provinces successfully fetched',
                'data' => RegionProvince::paginate(10)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        if (!isset($name)) {
            return response()->json([
                'status' => 422,
                'message' => 'Name is required',
                'data' => null
            ], 422);
        }

        $province = new RegionProvince(['id' => Str::uuid(), 'name' => $name]);

        if ($province->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'Province successfully saved'
            ], 200);
        }

        return response()->json([
            'status' => 400,
            'message' => 'Failed to save province'
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $province = RegionProvince::find($id);
            if (isset($province)) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Province found',
                    'data' => $province,
                ], 200);
            }

            return response()->json([
                'status' => 400,
                'message' => 'No data found',
            ], 400);
        } catch (\Exception $e) {

            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RegionProvince  $regionProvince
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $province = RegionProvince::find($id);

        if (!isset($province)) {
            return response()->json([
                'status' => 400,
                'message' => 'Data not found',
                'data' => null
            ], 400);
        }

        $province->name = $request->name;
        $province->save();

        return response()->json([
            'status' => 200,
            'message' => 'Data found',
            'data' => $province
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $province = RegionProvince::find($id);

        if (!isset($province)) {
            return response()->json([
                'status' => 400,
                'message' => 'Data not found',
                'data' => null
            ], 400);
        }
        $province->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Province successfully deleted',
            'data' => null
        ], 200);
    }
}
