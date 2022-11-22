<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


// TODO: Need to separate user and admin access
Route::middleware(['auth'])->group(function () {
    //Route::get('/forms', [RegisteredUserController::class, 'create'])->name('register');
    // Admin Routes
    Route::get('/form/create', [\App\Http\Controllers\FormCreateController::class, 'show'])->name('form-create');
    Route::post('/form/create', [\App\Http\Controllers\FormCreateController::class, 'create'])->name('form-create');

    Route::post('/form/submit', [\App\Http\Controllers\FormCreateController::class, 'submit'])->name('form-submit');

    Route::get('/form/list', [\App\Http\Controllers\FormListController::class, 'show'])->name('form-list');
    Route::get('/dashboard', [\App\Http\Controllers\FormListController::class, 'show']);//TODO: Remove this work around
    Route::get('/form/list', [\App\Http\Controllers\FormListController::class, 'show'])->name('dashboard');//TODO: Remove this work around
    Route::get('/form/{id}/stats', [\App\Http\Controllers\FormListController::class, 'stats'])->name('form-stats');

    // Todo: Randomized the ID in url to avoid predictability of URLs for other people's form
    Route::get('/form/{id}', [\App\Http\Controllers\FormListController::class, 'getShowById'])->name('form-by-id');
    Route::post('/form/{id}', [\App\Http\Controllers\FormListController::class, 'showById'])->name('form-by-id');


    //Testing

    Route::get('/form', [\App\Http\Controllers\FormListController::class, 'sampleForm'])->name('sampleform');


});

require __DIR__.'/auth.php';
