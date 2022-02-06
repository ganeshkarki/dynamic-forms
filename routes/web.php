<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    //Route::get('/forms', [RegisteredUserController::class, 'create'])->name('register');
    // Admin Routes
    Route::get('/form/create', [\App\Http\Controllers\FormCreateController::class, 'show'])->name('form-create');
    Route::post('/form/create', [\App\Http\Controllers\FormCreateController::class, 'create'])->name('form-create');

    Route::post('/form/preview', [\App\Http\Controllers\FormCreateController::class, 'preview'])->name('form-preview');
    Route::post('/form/submit', [\App\Http\Controllers\FormCreateController::class, 'submit'])->name('form-submit');

    Route::get('/form/list', [\App\Http\Controllers\FormListController::class, 'show'])->name('form-list');
    Route::get('/form/list/{id}', [\App\Http\Controllers\FormListController::class, 'showById'])->name('form-by-id');

});

require __DIR__.'/auth.php';
