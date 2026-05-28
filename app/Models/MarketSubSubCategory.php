<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketSubSubCategory extends Model
{
    protected $fillable = ['market_sub_category_id', 'name', 'description', 'image_path'];

    public function subCategory()
    {
        return $this->belongsTo(MarketSubCategory::class, 'market_sub_category_id');
    }
}
