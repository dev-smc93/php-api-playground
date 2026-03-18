<?php

use App\Http\Controllers\Api\AuctionItemController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::apiResource('posts', PostController::class);
Route::post('auction-items/{auction_item}/analyze', [AuctionItemController::class, 'analyze'])->name('auction-items.analyze');
Route::apiResource('auction-items', AuctionItemController::class);
