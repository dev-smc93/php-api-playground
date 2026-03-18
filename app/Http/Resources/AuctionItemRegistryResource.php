<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionItemRegistryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rank' => $this->rank,
            'receipt_date' => $this->receipt_date?->format('Y-m-d'),
            'right_type' => $this->right_type,
            'right_holder' => $this->right_holder,
            'claim_amount' => $this->claim_amount,
            'discharge_status' => $this->discharge_status,
            'remarks' => $this->remarks,
        ];
    }
}
