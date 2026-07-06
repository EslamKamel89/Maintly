<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\WorkOrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::prefix('/work-orders')
    ->name('work_orders.')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::get('/', [WorkOrdersController::class, 'index']);
    });
