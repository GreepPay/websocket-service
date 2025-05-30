<?php

use App\Http\Controllers\MessageController;
use App\Http\Controllers\P2POrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:custom')
    ->prefix('ws')
    ->group(function () {
        Route::post('/p2p-orders', [P2POrderController::class, 'create']);
        Route::put('/p2p-orders', [P2POrderController::class, 'update']);
        Route::post('/messages', [MessageController::class, 'create']);
    });
