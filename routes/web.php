<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::view('dashboard', 'dashboard')->name('dashboard');
});

// Route::get('/artisan', function () {
//     Artisan::call('storage:link');

//     return Artisan::output();
// });

require __DIR__ . '/settings.php';
