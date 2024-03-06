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
//rota de teste
Route::get('/teste', [App\Http\Controllers\IndexController::class, 'teste']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->group(function () {
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('profile', [App\Http\Controllers\UserController::class, 'editProfile'])->name('profile');
    Route::put('profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('profile.update');
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('pages', App\Http\Controllers\PageController::class);
    Route::post('pages/order', [App\Http\Controllers\PageController::class, 'order'])->name('pages.order');
    Route::resource('setores', App\Http\Controllers\SetorController::class);
});

Route::resource('publications', App\Http\Controllers\PublicationController::class);
Route::get('publications/previa/{publications}', [App\Http\Controllers\PublicationController::class, 'previa'])->name('publications.previa');
Route::post('publications/publicar/{publications}', [App\Http\Controllers\PublicationController::class, 'post'])->name('publications.publicar');
Route::post('/publications/{id}/despublicar', [App\Http\Controllers\PublicationController::class, 'despublicar'])->name('publications.despublicar');
//Route::get('teste', [App\Http\Controllers\PublicationController::class, 'imagemText'])->name('publications.teste');

Route::resource('birthdays', App\Http\Controllers\BirthdayController::class);
Route::post('birthdays-import',[App\Http\Controllers\BirthdayController::class, 'fileImport'])->name('birthdays.import');
Route::get('birthdays-modelo',[App\Http\Controllers\BirthdayController::class, 'modelo'])->name('birthdays.modelo');
Route::get('config', [App\Http\Controllers\ConfigController::class, 'index'])->name('config.index');
Route::put('config/{config}', [App\Http\Controllers\ConfigController::class, 'update'])->name('config.update');

Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
Route::post('/reports/generate', [App\Http\Controllers\ReportController::class, 'generate'])->name('reports.generate');




