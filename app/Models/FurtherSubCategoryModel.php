<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FurtherSubCategoryModel extends Model
{
    use HasFactory;

    protected $table = 'further_subcategories';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id', 
        'name', 
        'description', 
        'created_by', 
        'updated_by', 
        'created_at', 
        'updated_at', 
        'file_path',
        'parent',
        'is_published',
        'subcategory_id'
    ];

    /**
     * Get the subCategory that owns the FurtherSubCategoryModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategoryModel::class, 'subcategory_id', 'id');
    }
}
