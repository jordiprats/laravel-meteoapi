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


Route::get('/platges', 'PlatjaController@index')->name('platges.list');
Route::get('/platges/{platja_slug}', 'PlatjaController@show')->name('platges.show');

Route::get('/municipis', 'MunicipiController@index')->name('municipis.list');
Route::get('/municipis/previsio/{municipi_slug}', 'MunicipiController@show')->name('municipis.show');

Route::get('/comarques', 'ComarcaController@index')->name('comarques.list');
Route::get('/comarques/{comarca_slug}', 'ComarcaController@show')->name('comarca.show');
