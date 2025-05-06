<?php

use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use Pratiksh\Imperium\Http\Controllers\FileUploadController;
use Pratiksh\Imperium\Http\Controllers\ImperiumActionController;
use Pratiksh\Imperium\Http\Controllers\ImperiumResourceController;
use Pratiksh\Imperium\Http\Controllers\ModuleController;

Route::prefix('admin')->middleware(['auth', 'verified', HandlePrecognitiveRequests::class])->group(function () {});
