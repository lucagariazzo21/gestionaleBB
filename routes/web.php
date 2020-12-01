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
    return view('auth/login');
});

Auth::routes();

Route::get('/agenda', 'AgendaController@index')->name('agenda');

Route::prefix('prenotazioni')->name('prenotazioni.')->group(function () {
    Route::get('', 'PrenotazioniController@index')->name('prenotazioni');
    Route::get('detail', 'PrenotazioniController@detail')->name('detail');
    Route::get('check', 'PrenotazioniController@check')->name('check');
    Route::get('crea', 'PrenotazioniController@create')->name('create');
    Route::get('modifica/{prenotazione}', 'PrenotazioniController@edit')->name('edit');
    Route::get('cancella/{prenotazione}', 'PrenotazioniController@destroy')->name('destroy');
    Route::get('update', 'PrenotazioniController@update')->name('update');
});

Route::prefix('camere')->name('camere.')->group(function () {
    Route::get('', 'CamereController@index')->name('index');
    Route::get('crea', 'CamereController@create')->name('create');
    Route::get('modifica', 'CamereController@edit')->name('edit');
    Route::get('cancella/{camera}', 'CamereController@destroy')->name('destroy');
});

Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('', 'SettingController@detail')->name('detail');
    Route::get('modifica', 'SettingController@edit')->name('edit');
});

Route::prefix('ricavi')->name('ricavi.')->group(function () {
    Route::get('', 'StatisticController@index')->name('index');
    // Route::get('modifica', 'SettingController@edit')->name('edit');
});

Route::prefix('client')->name('client.')->group(function () {
    Route::get('crea', 'ClientController@crea')->name('crea');
    Route::get('', 'ClientController@index')->name('index');
    Route::get('edit', 'ClientController@edit')->name('edit');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
