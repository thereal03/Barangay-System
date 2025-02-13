<?php

use App\Http\Controllers\AppController as AppController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;


Route::get('{all}', [AppController::class, 'index'])->where('all', '^((?!api).)*')->name('index');

Route::get('/rss-feed-proxy', function () {
    $response = Http::get('https://www.philstar.com/rss/headlines');
    return response($response->body());
});

Route::get('/test', function () {
    return "Hello World";
});

// In web.php (Laravel routes)
Route::delete('/dashboard/admin/services/{id}', [ServiceController::class, 'destroy'])->name('services.destroy');
Route::get('/dashboard/admin/services/{id}/edit', [ServiceController::class, 'edit'])->name('services.edit');
