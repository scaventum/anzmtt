<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\BasicAuth;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::middleware([BasicAuth::class])->group(
  function () {
    // Preview routes
    Route::middleware([Authenticate::class])->group(function () {
      Route::get('/preview/{slug}', [PageController::class, 'preview'])
        ->where('slug', '.*')
        ->name('page.preview');
    });

    // Public page route
    Route::get('/{slug}', [PageController::class, 'show'])
      ->where('slug', '.*')
      ->name('page.show');
  }
);

// Post routes
Route::post('/contact', [ContactController::class, 'send'])
  ->name('contact.send');
