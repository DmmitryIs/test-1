<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['get','post'], '/registration', [MainController::class, 'registration'])->name('registration');
Route::get('/u{hash}/{show?}', [MainController::class, 'main'])->name('main');
Route::get('/generate', [MainController::class, 'generate'])->name('generate')->middleware('auth');
Route::post('/deactivate', [MainController::class, 'deactivate'])->name('deactivate')->middleware('auth');

Route::get('/admin/users', [AdminController::class, 'users']);
Route::get('/admin/users/{id}', [AdminController::class, 'userEdit'])->name('admin.user');
