<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketSubCategory extends Model
{
    protected $fillable = ['market_main_category_id', 'name', 'description', 'image_path'];

    public function mainCategory()
    {
        return $this->belongsTo(MarketMainCategory::class, 'market_main_category_id');
    }

    public function subSubCategories()
    {
        return $this->hasMany(MarketSubSubCategory::class, 'market_sub_category_id');
    }
}
