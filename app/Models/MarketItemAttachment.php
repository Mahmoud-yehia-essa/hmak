<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketItemAttachment extends Model
{
    protected $fillable = [
        'market_item_id',
        'attachment_name',
        'attachment_path',
        'type'
    ];

    public function marketItem()
    {
        return $this->belongsTo(MarketItem::class, 'market_item_id');
    }
}
