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

Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('pages', App\Http\Controllers\PageController::class);
    Route::post('pages/order', [App\Http\Controllers\PageController::class, 'order'])->name('pages.order');
});

Route::resource('publications', App\Http\Controllers\PublicationController::class);
Route::get('publications/previa/{publications}', [App\Http\Controllers\PublicationController::class, 'previa'])->name('publications.previa');
Route::post('publications/publicar/{publications}', [App\Http\Controllers\PublicationController::class, 'post'])->name('publications.publicar');


