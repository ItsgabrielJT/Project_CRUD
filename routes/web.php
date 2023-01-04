<?php

use App\Http\Controllers\ProductController;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::resource('product', ProductController::class);
    Route::resource('buyer', BuyerController::class);
    Route::resource('invoce', InvoceController::class);
    Route::resource('invoce-details', InvoceDetailController::class);
    Route::post('/invoice/complete/{invoce}', [InvoceController::class, 'completeSend'])->name('invoce.complete');
    Route::get('/invoice/add-product/{invoce}/', [InvoceDetailController::class, 'create'])->name('invoce.add_products');
});