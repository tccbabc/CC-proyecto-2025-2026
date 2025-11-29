<?php

use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\ColorGroupController;
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

Route::prefix('colors')->group(function () {
    Route::get('/', [ColorController::class, 'listColor']);
    Route::post('/', [ColorController::class, 'addColor']);
    Route::put('/{colorCode}', [ColorController::class, 'editColor']);
    Route::delete('/{colorCode}', [ColorController::class, 'delColor']);
});

Route::prefix('color-groups')->group(function () {
    Route::get('/', [ColorGroupController::class, 'listColorGroup']);
    Route::post('/', [ColorGroupController::class, 'addColorGroup']);
    Route::put('/{colorGroupCode}', [ColorGroupController::class, 'editColorGroup']);
    Route::delete('/{colorGroupCode}', [ColorGroupController::class, 'delColorGroup']);
    Route::post('/{colorGroupCode}/append-color/{colorCode}', [ColorGroupController::class, 'appendColor']);
    Route::delete('/{colorGroupCode}/remove-color/{colorCode}', [ColorGroupController::class, 'removeColor']);
});
