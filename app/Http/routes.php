<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'WelcomeController@index');
Route::get('gacha', 'GachaController@index');

Route::post('gacha/drawNormal', 'GachaController@draw_normal_gacha');
Route::post('gacha/drawExpensive', 'GachaController@draw_expensive_gacha');
Route::post('gacha/drawBox', 'GachaController@draw_box_gacha');

Route::get('home', 'HomeController@index');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
