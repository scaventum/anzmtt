<?php

use App\Http\Controllers\PageController;
use App\Http\Middleware\BasicAuth;
use Illuminate\Support\Facades\Route;

// Preview routes
Route::middleware([BasicAuth::class])->group(
  function () {
    Route::middleware(['auth'])->group(function () {
      Route::get('/preview/{page}', [PageController::class, 'show'])
        ->name('page.preview');
    });

    // Public page route
    Route::get('/{page}', [PageController::class, 'show'])
      ->where('page', '.*')
      ->name('page.show');
  }
);
