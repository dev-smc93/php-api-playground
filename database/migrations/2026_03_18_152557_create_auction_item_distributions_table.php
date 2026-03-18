<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auction_item_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auction_item_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('rank');
            $table->string('claim_type', 50)->nullable();
            $table->string('creditor_name', 100)->nullable();
            $table->unsignedBigInteger('claim_amount')->nullable();
            $table->unsignedBigInteger('distributed_amount')->nullable();
            $table->unsignedBigInteger('unpaid_amount')->nullable();
            $table->unsignedBigInteger('buyer_assumption')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_item_distributions');
    }
};
