<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuctionItemTenant extends Model
{
    protected $fillable = [
        'auction_item_id',
        'tenant_name',
        'occupancy_status',
        'move_in_date',
        'fixed_date',
        'dividend_request_date',
        'deposit_amount',
        'monthly_rent',
        'converted_deposit',
        'has_opposing_power',
        'remarks',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'fixed_date' => 'date',
        'dividend_request_date' => 'date',
        'has_opposing_power' => 'boolean',
    ];

    public function auctionItem(): BelongsTo
    {
        return $this->belongsTo(AuctionItem::class);
    }
}
