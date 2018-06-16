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

Route::get('/municipis', 'MunicipiController@index')->name('municipis.list');
Route::get('/municipis/{municipi_slug}', 'MunicipiController@show')->name('municipis.show');
Route::get('/municipis/{municipi_slug}/previsio', 'MunicipiController@previsio')->name('municipis.previsio');
Route::get('/municipis/{municipi_slug}/platges', 'MunicipiController@platges')->name('municipis.platges');
Route::get('/municipis/{municipi_slug}/platges/{platja_slug}', 'PlatjaController@show')->name('platges.show');
Route::get('/municipis/{municipi_slug}/platges/{platja_slug}/previsio', 'PlatjaController@previsio')->name('platges.show.previsio');

Route::get('/comarques', 'ComarcaController@index')->name('comarques.list');
Route::get('/comarques/{comarca_slug}', 'ComarcaController@show')->name('comarca.show');

Route::get('/estat', function()
{
    return ['estat' => 'República de Catalunya'];
});
