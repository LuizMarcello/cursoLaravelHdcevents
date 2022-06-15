<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

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

Route::get('/', [EventController::class, 'index']);

/* Acrescentando o "middleware auth" nesta rota. Assim
   criará um evento somente quando estiver autenticado. */
Route::get('/events/create', [EventController::class, 'create'])
    ->name('criarevento')->middleware('auth');

Route::get('/events/{id}', [EventController::class, 'show']);

Route::post('/events', [EventController::class, 'store']);

Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth');

Route::get('/events/edit/{id}', [EventController::class, 'edit'])->middleware('auth');

Route::put('/events/update/{id}', [EventController::class, 'update'])->middleware('auth');

Route::get('/contact', function () {
    return view('contact');
});

/* Action "dashboard" deste controller */
Route::get('/dashboard', [EventController::class, 'dashboard'])->middleware('auth');

Route::get('/usuariologado', [EventController::class, 'logoff'])->name('logoff');
