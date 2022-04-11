<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RegionCity;

class RegionDistrict extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;
  protected $fillable = [
    'id',
    'city_id',
    'name'
  ];

  public function city()
  {
    return $this->belongsTo(RegionCity::class);
  }
}
