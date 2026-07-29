<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\WorkOrderAttachmentsController;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('/work-orders')->name('work_orders.')->group(function () {
        Route::get('/', [WorkOrdersController::class, 'index']);
        Route::get('/{workOrder}', [WorkOrdersController::class, 'show']);
        Route::post('/{workOrder}/complete', [WorkOrdersController::class, 'complete']);
    });

    Route::prefix('/comments')->name('comments.')->group(function () {
        Route::post('/', [CommentsController::class, 'store']);
    });
    Route::prefix('/attachments')->name('attachments.')->group(function () {
        Route::post('/', [WorkOrderAttachmentsController::class, 'store']);
    });
});
