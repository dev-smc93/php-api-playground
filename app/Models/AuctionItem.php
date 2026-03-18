<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AuctionItem extends Model
{
    protected $fillable = [
        'case_number',
        'court_name',
        'location',
        'road_address',
        'property_type',
        'case_registered_at',
        'auction_type',
        'land_area_sqm',
        'building_area_sqm',
        'owner_name',
        'debtor_name',
        'creditor_name',
        'appraised_value',
        'lowest_bid_price',
        'deposit_amount',
        'dividend_deadline',
        'sale_conditions',
        'cancellation_standard_date',
        'total_registered_claims',
    ];

    protected $casts = [
        'case_registered_at' => 'date',
        'dividend_deadline' => 'date',
        'cancellation_standard_date' => 'date',
        'land_area_sqm' => 'decimal:2',
        'building_area_sqm' => 'decimal:2',
    ];

    public function registries(): HasMany
    {
        return $this->hasMany(AuctionItemRegistry::class)->orderBy('rank');
    }

    public function tenants(): HasMany
    {
        return $this->hasMany(AuctionItemTenant::class);
    }

    public function distributions(): HasMany
    {
        return $this->hasMany(AuctionItemDistribution::class)->orderBy('rank');
    }
}
