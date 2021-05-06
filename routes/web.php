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
    return redirect('orders');
});


Route::get('/home', function () {
    return redirect('orders');
});

Auth::routes();

Route::resource('clients', 'ClientController');

Route::post('/filter/orders', 'OrderController@index')->name('orders.filter');
Route::resource('orders', 'OrderController');
Route::get('/orders/download/{id}', 'OrderController@downloadFile')->name('orders.download');
Route::get('/orders/client/{client_id}', 'OrderController@clientOrders')->name('orders.client');

Route::resource('users', 'UserController');
Route::get('/settings', 'UserController@editSelf')->name('users.editself');
Route::patch('/update_self', 'UserController@updateSelf')->name('users.updateself');

Route::get('/admin', function () {
    return redirect('orders');
})->name('home');

Route::get('/graphs', 'HomeController@index')->name('graphs');
Route::post('/graphs', 'HomeController@index')->name('graphs');

Route::get('/logs', 'LogController@index')->name('logs');
