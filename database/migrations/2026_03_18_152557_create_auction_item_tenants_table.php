<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auction_item_tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_item_id')->constrained()->cascadeOnDelete();
            $table->string('tenant_name', 100);
            $table->string('occupancy_status', 255)->nullable();
            $table->date('move_in_date')->nullable();
            $table->date('fixed_date')->nullable();
            $table->date('dividend_request_date')->nullable();
            $table->unsignedBigInteger('deposit_amount')->nullable();
            $table->unsignedBigInteger('monthly_rent')->nullable();
            $table->unsignedBigInteger('converted_deposit')->nullable();
            $table->boolean('has_opposing_power')->default(false);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_item_tenants');
    }
};
