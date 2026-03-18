<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionItemDistributionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rank' => $this->rank,
            'claim_type' => $this->claim_type,
            'creditor_name' => $this->creditor_name,
            'claim_amount' => $this->claim_amount,
            'distributed_amount' => $this->distributed_amount,
            'unpaid_amount' => $this->unpaid_amount,
            'buyer_assumption' => $this->buyer_assumption,
        ];
    }
}
