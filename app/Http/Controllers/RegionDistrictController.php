<?php

namespace App\Http\Controllers;

use App\Models\RegionCity;
use App\Models\RegionDistrict;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegionDistrictController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    return response()->json([
      'data' => RegionDistrict::paginate(10),
      'status' => 200,
      'message' => 'Districts successfuly fetched'
    ], 200);
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
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(Request $request)
  {
    if (!$request->has('city_id')) {
      return response()->json([
        'status' => 422,
        'message' => 'City Id is required',
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

    $city = RegionCity::find($request->input('city_id'));
    if (empty($city)) {
      return response()->json([
        'status' => 400,
        'message' => 'City not found'
      ], 400);
    }

    $district = new RegionDistrict(['id' => Str::uuid(), 'name' => $request->name, 'city_id' => $request->city_id]);

    if ($district->save()) {
      return response()->json([
        'status' => 200,
        'message' => 'District successfully saved'
      ], 200);
    }

    return response()->json([
      'status' => 400,
      'message' => 'Failed to save district'
    ], 400);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\RegionDistrict  $regionDistrict
   * @return \Illuminate\Http\Response
   */
  public function show(RegionDistrict $regionDistrict)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\RegionDistrict  $regionDistrict
   * @return \Illuminate\Http\Response
   */
  public function edit(RegionDistrict $regionDistrict)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\RegionDistrict  $regionDistrict
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, RegionDistrict $regionDistrict)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\RegionDistrict  $regionDistrict
   * @return \Illuminate\Http\Response
   */
  public function destroy(RegionDistrict $regionDistrict)
  {
    //
  }

  public function getByCityId($city_id)
  {
    $districts = RegionDistrict::where('city_id', $city_id)->get();
    return response()->json([
      'status' => 200,
      'data' => $districts,
      'message' => 'Districts successfully fetched'
    ]);
  }
}
