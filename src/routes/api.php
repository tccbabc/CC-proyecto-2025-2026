<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SizeController;
use App\Http\Controllers\Api\SizeGroupController;

Route::prefix('sizes')->group(function () {
    Route::get('/', [SizeController::class, 'listSize']);
    Route::post('/', [SizeController::class, 'addSize']);
    Route::put('/{sizeCode}', [SizeController::class, 'editSize']);
    Route::delete('/{sizeCode}', [SizeController::class, 'delSize']);
});

Route::prefix('size-groups')->group(function () {
    Route::get('/', [SizeGroupController::class, 'listSizeGroup']);
    Route::post('/', [SizeGroupController::class, 'addSizeGroup']);
    Route::put('/{sizeGroupCode}', [SizeGroupController::class, 'editSizeGroup']);
    Route::delete('/{sizeGroupCode}', [SizeGroupController::class, 'delSizeGroup']);
    Route::post('/{sizeGroupCode}/append-size/{sizeCode}', [SizeGroupController::class, 'appendSize']);
    Route::delete('/{sizeGroupCode}/remove-size/{sizeCode}', [SizeGroupController::class, 'removeSize']);
});
