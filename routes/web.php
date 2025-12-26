<?php

use App\Http\Controllers\PageController;
use App\Http\Middleware\BasicAuth;
use Illuminate\Support\Facades\Route;

Route::middleware([BasicAuth::class])->group(
  function () {
    // Preview routes
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
