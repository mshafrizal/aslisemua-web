<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FurtherSubCategoryModel;
use App\Models\CategoryModel;

class SubCategoryModel extends Model
{
    use HasFactory;

    protected $table = 'subcategories';
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
        'category_id'
    ];

    /**
     * Get all of the furtherSubCategory for the SubCategoryModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function furtherSubCategory()
    {
        return $this->hasMany(FurtherSubCategoryModel::class, 'subcategory_id', 'id');
    }

    /**
     * Get the category that owns the SubCategoryModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(CategoryModel::class);
    }
}
