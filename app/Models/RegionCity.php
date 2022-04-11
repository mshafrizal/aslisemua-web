<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RegionDistrict;
use App\Models\RegionProvince;

class RegionCity extends Model
{
  use HasFactory;
  use SoftDeletes;
  public $incrementing = false;

  protected $fillable = [
    'id',
    'province_id',
    'name',
  ];

  public function province()
  {
    return $this->belongsTo(RegionProvince::class);
  }

  public function district()
  {
    return $this->hasMany(RegionDistrict::class);
  }
}
