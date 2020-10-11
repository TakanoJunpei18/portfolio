<?php

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

Route::group(['prefix' => 'admin'], function() {   
    Route::get('output/create','Admin\outputController@add')->middleware('auth');
    Route::post('output/create', 'Admin\outputController@create')->middleware('auth');
    
    Route::get('output', 'Admin\outputController@index')->middleware('auth');
  
    Route::get('output/edit', 'Admin\outputController@edit')->middleware('auth');
    Route::post('output/edit', 'Admin\outputController@update')->middleware('auth');
   
    Route::get('output/delete', 'Admin\outputController@delete')->middleware('auth');
   
   

}); 

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
?>    
