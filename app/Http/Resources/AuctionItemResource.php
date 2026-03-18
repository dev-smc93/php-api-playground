<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionItemResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'case_number' => $this->case_number,
            'court_name' => $this->court_name,
            'location' => $this->location,
            'road_address' => $this->road_address,
            'property_type' => $this->property_type,
            'case_registered_at' => $this->case_registered_at?->format('Y-m-d'),
            'auction_type' => $this->auction_type,
            'land_area_sqm' => $this->land_area_sqm,
            'building_area_sqm' => $this->building_area_sqm,
            'owner_name' => $this->owner_name,
            'debtor_name' => $this->debtor_name,
            'creditor_name' => $this->creditor_name,
            'appraised_value' => $this->appraised_value,
            'lowest_bid_price' => $this->lowest_bid_price,
            'deposit_amount' => $this->deposit_amount,
            'dividend_deadline' => $this->dividend_deadline?->format('Y-m-d'),
            'sale_conditions' => $this->sale_conditions,
            'cancellation_standard_date' => $this->cancellation_standard_date?->format('Y-m-d'),
            'total_registered_claims' => $this->total_registered_claims,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
            'registries' => AuctionItemRegistryResource::collection($this->whenLoaded('registries')),
            'tenants' => AuctionItemTenantResource::collection($this->whenLoaded('tenants')),
            'distributions' => AuctionItemDistributionResource::collection($this->whenLoaded('distributions')),
        ];
    }
}
