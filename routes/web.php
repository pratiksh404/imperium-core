<?php

use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth', 'verified', HandlePrecognitiveRequests::class])->group(function () {});
