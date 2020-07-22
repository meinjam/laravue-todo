<?php

use Illuminate\Support\Facades\Route;

Route::get( '/', function () {
    return view( 'welcome' );
} );

// Route::get( 'get_post/{id}', 'TodoController@edit' );
// Route::post( 'edit_post', 'TodoController@update' );
Route::resource( 'todo', 'TodoController' )->only( ['index', 'store'] );
Route::post( 'delete_todo', 'TodoController@destroy' );

Auth::routes();

Route::get( '/home', 'HomeController@index' )->name( 'home' );
