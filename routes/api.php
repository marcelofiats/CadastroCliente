<?php

use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use App\Models\User;
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

Route::group(array('prefix'=> 'users'), function(){
    Route::post('/create', [UserController::class, 'create']);
    Route::get('/get_all', [UserController::class, 'getAll']);
    Route::get('/get', [UserController::class, 'getById']);
    Route::put('/delete', [UserController::class, 'delete']);
    Route::get('/transactions', [TransactionController::class, 'getByClient']);
    Route::get('/alter_balance', [UserController::class, 'alterBalance']);
    Route::get('/movements', [UserController::class, 'movements']);
});

Route::group(array('prefix'=> 'transactions'), function(){
    Route::post('/create', [TransactionController::class, 'create']);
    Route::get('/get', [TransactionController::class, 'getById']);
    Route::put('/cancel', [TransactionController::class, 'cancel']);
    Route::get('/extract', [TransactionController::class, 'extract']);
    Route::get('/balance', [TransactionController::class, 'balance']);
});

