<?php

use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use Pratiksh\Imperium\Http\Controllers\FileUploadController;
use Pratiksh\Imperium\Http\Controllers\ImperiumActionController;
use Pratiksh\Imperium\Http\Controllers\ImperiumResourceController;
use Pratiksh\Imperium\Http\Controllers\ModuleController;

Route::prefix('admin')->middleware(['auth', 'verified', HandlePrecognitiveRequests::class])->group(function () {
    // Imperium Routes
    Route::post('get-dependencies/{module_name}/{dependable_field_name}', [ImperiumResourceController::class, 'getDependencyValues'])->name('getDependencies');
    Route::post('resource-action/{module_name}/{action_name}', [ImperiumResourceController::class, 'resourceAction'])->name('resourceAction');
    Route::post('imperium/action', [ImperiumActionController::class, 'handleAction'])->name('imperium.action');

    // Module Routes
    Route::delete('/bulk-delete/{model}', [ModuleController::class, 'bulkDelete'])
        ->name('bulk-delete');

    Route::post('/reorder/{model}', [ModuleController::class, 'reorder'])
        ->name('reorder');

    Route::patch('/restore/{model}/{id}', [ModuleController::class, 'restore'])
        ->name('restore');

    Route::post('/upload/process', [FileUploadController::class, 'process'])
        ->name('upload.process');

    Route::delete('/upload/revert', [FileUploadController::class, 'revert'])
        ->name('upload.revert');
});
