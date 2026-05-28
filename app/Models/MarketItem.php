<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketItem extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'image_path',
        'market_main_category_id',
        'market_sub_category_id',
        'market_sub_sub_category_id',
        'phone',
        'whatsapp',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mainCategory()
    {
        return $this->belongsTo(MarketMainCategory::class, 'market_main_category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(MarketSubCategory::class, 'market_sub_category_id');
    }

    public function subSubCategory()
    {
        return $this->belongsTo(MarketSubSubCategory::class, 'market_sub_sub_category_id');
    }

    public function attachments()
    {
        return $this->hasMany(MarketItemAttachment::class, 'market_item_id');
    }
}
