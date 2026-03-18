<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAuctionItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'case_number' => ['sometimes', 'string', 'max:50'],
            'court_name' => ['nullable', 'string', 'max:100'],
            'location' => ['sometimes', 'string', 'max:255'],
            'road_address' => ['nullable', 'string', 'max:255'],
            'property_type' => ['nullable', 'string', 'max:50'],
            'case_registered_at' => ['nullable', 'date'],
            'auction_type' => ['nullable', 'string', 'max:50'],
            'land_area_sqm' => ['nullable', 'numeric', 'min:0'],
            'building_area_sqm' => ['nullable', 'numeric', 'min:0'],
            'owner_name' => ['nullable', 'string', 'max:100'],
            'debtor_name' => ['nullable', 'string', 'max:100'],
            'creditor_name' => ['nullable', 'string', 'max:100'],
            'appraised_value' => ['nullable', 'integer', 'min:0'],
            'lowest_bid_price' => ['nullable', 'integer', 'min:0'],
            'deposit_amount' => ['nullable', 'integer', 'min:0'],
            'dividend_deadline' => ['nullable', 'date'],
            'sale_conditions' => ['nullable', 'string'],
            'cancellation_standard_date' => ['nullable', 'date'],
            'total_registered_claims' => ['nullable', 'integer', 'min:0'],
            'registries' => ['nullable', 'array'],
            'registries.*.rank' => ['required', 'integer', 'min:1'],
            'registries.*.receipt_date' => ['nullable', 'date'],
            'registries.*.right_type' => ['nullable', 'string', 'max:50'],
            'registries.*.right_holder' => ['nullable', 'string', 'max:100'],
            'registries.*.claim_amount' => ['nullable', 'integer', 'min:0'],
            'registries.*.discharge_status' => ['nullable', 'string', 'max:50'],
            'registries.*.remarks' => ['nullable', 'string'],
            'tenants' => ['nullable', 'array'],
            'tenants.*.tenant_name' => ['required', 'string', 'max:100'],
            'tenants.*.occupancy_status' => ['nullable', 'string', 'max:255'],
            'tenants.*.move_in_date' => ['nullable', 'date'],
            'tenants.*.fixed_date' => ['nullable', 'date'],
            'tenants.*.dividend_request_date' => ['nullable', 'date'],
            'tenants.*.deposit_amount' => ['nullable', 'integer', 'min:0'],
            'tenants.*.monthly_rent' => ['nullable', 'integer', 'min:0'],
            'tenants.*.converted_deposit' => ['nullable', 'integer', 'min:0'],
            'tenants.*.has_opposing_power' => ['nullable', 'boolean'],
            'tenants.*.remarks' => ['nullable', 'string'],
            'distributions' => ['nullable', 'array'],
            'distributions.*.rank' => ['required', 'integer', 'min:1'],
            'distributions.*.claim_type' => ['nullable', 'string', 'max:50'],
            'distributions.*.creditor_name' => ['nullable', 'string', 'max:100'],
            'distributions.*.claim_amount' => ['nullable', 'integer', 'min:0'],
            'distributions.*.distributed_amount' => ['nullable', 'integer', 'min:0'],
            'distributions.*.unpaid_amount' => ['nullable', 'integer', 'min:0'],
            'distributions.*.buyer_assumption' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
