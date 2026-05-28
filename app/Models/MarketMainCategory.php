<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketMainCategory extends Model
{
    protected $fillable = ['name', 'description', 'image_path'];

    public function subCategories()
    {
        return $this->hasMany(MarketSubCategory::class, 'market_main_category_id');
    }
}
