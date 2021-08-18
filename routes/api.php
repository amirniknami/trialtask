<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('shifts',\App\Http\Controllers\ShiftController::class)->only('store','index');

Route::delete('/empty-app-data',\App\Http\Controllers\DataBaseController::class);


Route::delete('/shifts',)->name('shifts.destroy');


