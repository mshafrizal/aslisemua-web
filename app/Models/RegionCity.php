<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}