<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ConsignModel;

class ConsignmentImageModel extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $table = 'consignments_images';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'consignment_id',
        'image_path',
        'image_name',
        'created_at',
        'updated_at',
        'file_id',
        'filename'
    ];

    /**
     * Get the brand that owns the ConsignModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consignment()
    {
        return $this->belongsTo(ConsignModel::class, 'consignment_id', 'id');
    }
}
