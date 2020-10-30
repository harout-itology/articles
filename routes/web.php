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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['auth', 'verified']], function() {

    //display articles list
    Route::get('articles', 'ArticleController@index')->name('articles.index');
    //create a new article
    Route::post('articles','ArticleController@store')->name('articles.store');
    //display edit article form
    Route::get('articles/{article}/edit','ArticleController@edit')->name('articles.edit');
    //delete a article
    Route::delete('articles/{article}','ArticleController@destroy')->name('articles.delete');

});
