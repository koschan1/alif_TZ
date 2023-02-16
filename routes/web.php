<?php

use Illuminate\Support\Facades\Route;


Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['namespace' => 'Users', 'middleware' => ['auth', 'user']], function (){
    Route::get('/', 'IndexController@index')->name('user.index');
    Route::get('/create', 'ContactController@index')->name('contact.create');
    Route::post('/create', 'ContactController@store')->name('contact.store');
    Route::get('/show/{contact}', 'ContactController@show')->name('contact.show');
    Route::get('/{contact}/edit', 'ContactController@edit')->name('contact.edit');
    Route::patch('/edit/{contact}', 'ContactController@update')->name('contact.update');
    Route::delete('/edit/{contact}', 'ContactController@destroy')->name('contact.destroy');
});

