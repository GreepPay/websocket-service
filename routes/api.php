<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopOrderController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\P2POrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes for broadcast-triggering endpoints, protected by `auth:custom`.
| All grouped under /ws to distinguish WebSocket-related actions.
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:custom')
    ->prefix('ws')
    ->group(function () {
        // P2P Order Events
        Route::post('/p2p-orders', [P2POrderController::class, 'create']);
        Route::put('/p2p-orders', [P2POrderController::class, 'update']);

        // Messaging Events
        Route::post('/messages', [MessageController::class, 'create']);

        // Product Events
        Route::post('/products', [ProductController::class, 'create']);
        Route::put('/products', [ProductController::class, 'update']);

        // Shop Order Events
        Route::post('/shop-orders', [ShopOrderController::class, 'create']);
        Route::put('/shop-orders', [ShopOrderController::class, 'update']);

        // Transaction Events
        Route::post('/transactions', [TransactionController::class, 'create']);
        Route::put('/transactions', [TransactionController::class, 'update']);
    });
