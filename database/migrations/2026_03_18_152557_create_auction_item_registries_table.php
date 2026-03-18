<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auction_item_registries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_item_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('rank');
            $table->date('receipt_date')->nullable();
            $table->string('right_type', 50)->nullable();
            $table->string('right_holder', 100)->nullable();
            $table->unsignedBigInteger('claim_amount')->nullable();
            $table->string('discharge_status', 50)->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_item_registries');
    }
};
