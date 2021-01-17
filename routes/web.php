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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test',  function(){
    return "GoodBye";
});

Route::get('/rooms/{roomType?}', 'ShowRoomsController');

// Route::get('/booking', 'BookingController@index');
// Route::get('/booking/create', 'BookingController@create');
// Route::post('/booking', 'BookingController@store');
// Route::get('/booking/{booking}', 'BookingController@show');
// Route::get('/booking/{booking}/edit', 'BookingController@edit');
// Route::put('/booking/{booking}', 'BookingController@update');
// Route::delete('/booking/{booking}', 'BookingController@destroy');

Route::resource('booking', 'BookingController');

Route::resource('room_types', 'RoomTypeController');


// Route::get('polls', 'PollsController@index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Web')->group( function(){
    Route::resource('team', 'TeamController');
});

Route::resource('users', 'UserController');