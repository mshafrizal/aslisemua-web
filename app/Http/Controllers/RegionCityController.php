<?php

namespace App\Http\Controllers;

use App\Models\RegionProvince;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\RegionCity;

class RegionCityController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return JsonResponse
   */
  public function index()
  {
    return response()->json([
      'data' => RegionCity::paginate(10),
      'status' => 200,
      'message' => 'Cities successfully fetched'
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return JsonResponse
   */
  public function store(Request $request)
  {
    if (!$request->has('province_id')) {
      return response()->json([
        'status' => 422,
        'message' => 'Province Id is required',
        'data' => null,
      ], 422);
    }

    if (!$request->has('name')) {
      return response()->json([
        'status' => 422,
        'message' => 'Name is required',
        'data' => null,
      ], 422);
    }

    $province = RegionProvince::find($request->input('province_id'));
    if (empty($province)) {
      return response()->json([
        'status' => 400,
        'message' => 'Province not found'
      ], 400);
    }

    $city = new RegionCity(['id' => Str::uuid(), 'name' => $request->name, 'province_id' => $request->province_id]);

    if ($city->save()) {
      return response()->json([
        'status' => 200,
        'message' => 'City successfully saved'
      ], 200);
    }

    return response()->json([
      'status' => 400,
      'message' => 'Failed to save city'
    ], 400);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  $id
   * @return JsonResponse
   */
  public function update(Request $request, $id)
  {
    if (!isset($id)) {
      return response()->json([
        'status' => 400,
        'message' => 'City id is missing'
      ], 400);
    }

    if (!$request->has('name')) {
      return response()->json([
        'status' => 400,
        'message' => 'Name is required'
      ], 400);
    }

    if (!$request->has('province_id')) {
      return response()->json([
        'status' => 400,
        'message' => 'Province id is required'
      ], 400);
    }

    $province = RegionProvince::find($request->input('province_id'));
    if (empty($province)) {
      return response()->json([
        'status' => 400,
        'message' => 'Province not found'
      ], 400);
    }

    $city = RegionCity::find($id);
    if (empty($city)) {
      return response()->json([
        'status' => 400,
        'message' => 'City not found'
      ], 400);
    }

    $city->name = $request->name;
    $city->province_id = $request->name;

    if ($city->save()) {
      return response()->json([
        'status' => 200,
        'message' => 'City successfully updated'
      ], 200);
    }

    return response()->json([
      'status' => 400,
      'message' => 'Failed to save city'
    ], 400);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return JsonResponse
   */
  public function destroy($id)
  {
    if (!isset($id)) {
      return response()->json([
        'status' => 400,
        'message' => 'City id is required'
      ], 400);
    }

    $city = RegionCity::find($id);

    if (empty($city)) {
      return response()->json([
        'status' => 400,
        'message' => 'City not found'
      ], 400);
    }

    $city->delete();

    return response()->json([
      'status' => 200,
      'message' => 'City deleted successfully'
    ], 200);
  }


  public function getByProvinceId($province_id)
  {
    $cities = RegionCity::where('province_id', $province_id)->get();
    return response()->json([
      'status' => 200,
      'message' => 'Cities successfully fetched',
      'data' => $cities
    ], 200);
  }
}
