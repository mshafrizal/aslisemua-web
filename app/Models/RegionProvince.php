<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RegionCity;

class RegionProvince extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;
    protected $fillable = [
        'id',
        'name',
    ];

    public function city()
    {
        return $this->hasMany(RegionCity::class);
    }
}
