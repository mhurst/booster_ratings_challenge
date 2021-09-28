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

Route::view('/', 'fundraisers');

Route::view('/fundraisers-review-form/{id}', 'fundraisersform');

route::get('/verify-email/{token}/{email}',[App\Http\Controllers\ReviewerController::class, 'verifyToken']);