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

Route::view('/','welcome');
Auth::routes();

Route::get('/login/pigeon', 'Auth\LoginController@showPigeonLoginForm')->name('login.pigeon');
Route::get('/login/driver', 'Auth\LoginController@showDriverLoginForm')->name('login.driver');;
Route::get('/login/restaurant', 'Auth\LoginController@showRestaurantLoginForm')->name('login.restaurant');;
Route::get('/register/pigeon', 'Auth\RegisterController@showPigeonRegisterForm')->name('register.pigeon');
Route::get('/register/driver', 'Auth\RegisterController@showDriverRegisterForm')->name('register.driver');
Route::get('/register/restaurant', 'Auth\RegisterController@showRestaurantRegisterForm')->name('register.restaurant');

Route::post('/login/pigeon', 'Auth\LoginController@pigeonLogin');
Route::post('/login/driver', 'Auth\LoginController@driverLogin');
Route::post('/login/restaurant', 'Auth\LoginController@restaurantLogin');
Route::post('/register/pigeon', 'Auth\RegisterController@createPigeon')->name('register.pigeon');
Route::post('/register/driver', 'Auth\RegisterController@createDriver')->name('register.driver');
Route::post('/register/restaurant', 'Auth\RegisterController@createrestaurant')->name('register.restaurant');
Route::view('/get-back-to-you', 'get-back-to-you');

Route::get('/home', 'HomeController@index')->name('home');//->middleware('auth');
Route::get('/account/settings', 'HomeController@settings')->middleware('auth');
Route::get('/r/{restaurant}', 'HomeController@show')->name('home.show');

Route::group(['middleware' => 'auth:pigeon'], function () {
    Route::get('/pigeon', 'PigeonController@index')->name('pigeon.index');
    Route::get('/pigeon/details/{restaurant}', 'PigeonController@details')->name('pigeon.details');
    Route::patch('/pigeon/details/{restaurant}', 'PigeonController@setTempPassword')->name('pigeon.setTempPass');
});

Route::group(['middleware' => 'auth:driver'], function () {
    Route::view('/driver', 'driver');
});

Route::group(['middleware' => 'auth:restaurant'], function () {
    Route::get('/restaurant', 'RestaurantController@index')->name('restaurant.index');
    Route::get('/management', 'RestaurantController@management')->name('restaurant.manage');
    Route::post('/management', 'RestaurantController@addCategory')->name('addCategory');
});

Route::get('/account/address/create', 'AddressController@create')->name('address.create');
Route::post('/account/address', 'AddressController@store')->name('address.store');
