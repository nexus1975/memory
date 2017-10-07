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

/* Memory game */
Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');
 
Route::controllers([
    'auth' => '\App\Http\Controllers\Auth\AuthController',
    'auth/confirm/{token}' => '\App\Http\Controllers\Auth\AuthController',
    'password' => '\App\Http\Controllers\Auth\PasswordController',    
]);

Route::group(['prefix' => 'api','middleware' => ['auth']], function() {
    //Pictures
    Route::resource('pictures', 'PicturesController');
    //Boards
    Route::resource('board', 'BoardsController');
    //Games
    Route::resource('game', 'GamesController');
    //Config
    Route::resource('config', 'ConfigController');                                        
});


/* Geoloc */
//auth
Route::group(['middleware' => ['auth']], function() {
    Route::get('geo', 'GeolocController@index');
    Route::get('geo/read/{hours}/{maxid}', 'GeolocController@getdata');
    Route::post('geo/panel', 'GeolocController@panelData');
    Route::get('geo/userdevice', 'GeolocController@getUserDevice');
    Route::post('geo/userdevice', 'GeolocController@addUserDevice');
    Route::delete('geo/userdevice/{udid}', 'GeolocController@deleteUserDevice');
    Route::put('geo/defaultdevice/{udid}', 'GeolocController@setDefaultDevice');
    Route::get('geo/savedroutes', 'GeolocController@getSavedRoutes');
    Route::get('geo/savedroutes/{srid}', 'GeolocController@getSavedRoute');
});
//public
Route::group(['prefix' => 'ext'], function() {
    Route::resource('geo', 'GeolocController');        
    Route::post('upload', 'GeolocController@upload'); 
    Route::post('saveroute', 'GeolocController@saveRoute');
});   

/*
Route::get('/', function() {   
    View::make('index'); // will return app/views/index.php 
});
*/

//Route::get('geoloc/setdevice/imei/{imei}', 'GeolocController@setDevice');     
