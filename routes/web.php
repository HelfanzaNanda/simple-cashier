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
    return redirect()->route('food.index');
});

Route::get('food', 'FoodController@index')->name('food.index');
Route::get('food/create', 'FoodController@create')->name('food.create');
Route::post('food/create', 'FoodController@store')->name('food.store');

Route::get('transaction', 'TransactionController@index')->name('transaction.index');
Route::post('transaction/print', 'TransactionController@print')->name('transaction.print');