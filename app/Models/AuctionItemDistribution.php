<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuctionItemDistribution extends Model
{
    protected $fillable = [
        'auction_item_id',
        'rank',
        'claim_type',
        'creditor_name',
        'claim_amount',
        'distributed_amount',
        'unpaid_amount',
        'buyer_assumption',
    ];

    public function auctionItem(): BelongsTo
    {
        return $this->belongsTo(AuctionItem::class);
    }
}
