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

Route::get('/events/create', [EventController::class, 'create'])->name('criarevento');


/* Route::get('/contact', function () {
    return view('contact');
}); */

/* Route::get('/produtos', function () {

    $busca = request('search');

    return view('products', ['buscaa' => $busca]);
}); */

/* Route::get('/produtos_teste/{id?}', function ($id = null) {
    return view('product', ['idd' => $id]);
}); */
