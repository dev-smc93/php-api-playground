<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionItemTenantResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tenant_name' => $this->tenant_name,
            'occupancy_status' => $this->occupancy_status,
            'move_in_date' => $this->move_in_date?->format('Y-m-d'),
            'fixed_date' => $this->fixed_date?->format('Y-m-d'),
            'dividend_request_date' => $this->dividend_request_date?->format('Y-m-d'),
            'deposit_amount' => $this->deposit_amount,
            'monthly_rent' => $this->monthly_rent,
            'converted_deposit' => $this->converted_deposit,
            'has_opposing_power' => $this->has_opposing_power,
            'remarks' => $this->remarks,
        ];
    }
}
