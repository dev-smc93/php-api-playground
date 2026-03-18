<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuctionItemRegistry extends Model
{
    protected $fillable = [
        'auction_item_id',
        'rank',
        'receipt_date',
        'right_type',
        'right_holder',
        'claim_amount',
        'discharge_status',
        'remarks',
    ];

    protected $casts = [
        'receipt_date' => 'date',
    ];

    public function auctionItem(): BelongsTo
    {
        return $this->belongsTo(AuctionItem::class);
    }
}
