<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auction_items', function (Blueprint $table) {
            $table->id();
            $table->string('case_number', 50);
            $table->string('court_name', 100)->nullable();
            $table->string('location', 255);
            $table->string('road_address', 255)->nullable();
            $table->string('property_type', 50)->nullable();
            $table->date('case_registered_at')->nullable();
            $table->string('auction_type', 50)->nullable();
            $table->decimal('land_area_sqm', 12, 2)->nullable();
            $table->decimal('building_area_sqm', 12, 2)->nullable();
            $table->string('owner_name', 100)->nullable();
            $table->string('debtor_name', 100)->nullable();
            $table->string('creditor_name', 100)->nullable();
            $table->unsignedBigInteger('appraised_value')->nullable();
            $table->unsignedBigInteger('lowest_bid_price')->nullable();
            $table->unsignedBigInteger('deposit_amount')->nullable();
            $table->date('dividend_deadline')->nullable();
            $table->text('sale_conditions')->nullable();
            $table->date('cancellation_standard_date')->nullable();
            $table->unsignedBigInteger('total_registered_claims')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_items');
    }
};
