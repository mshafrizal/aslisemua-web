<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategoryModel;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'categories';
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
    ];
}
