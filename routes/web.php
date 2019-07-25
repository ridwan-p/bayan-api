<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('login', "AuthController@login");
$router->post('refresh', "AuthController@refresh");
$router->post('logout', "AuthController@logout");
$router->get('profile', "AuthController@profile");


$router->group(['middleware' => 'auth:api'], function () use ($router) {
    $router->get('users', 'UserController@index');
	$router->get('users/{id}', 'UserController@show');
	$router->post('users', "UserController@store");
	$router->put('users/{id}', "UserController@update");
	$router->delete('users/{id}', "UserController@destroy");

	$router->get('reciters', 'ReciterController@index');
	$router->get('reciters/{id}', 'ReciterController@show');
	$router->post('reciters', 'ReciterController@store');
	$router->patch('reciters/{id}', 'ReciterController@update');
	$router->delete('reciters/{id}', 'ReciterController@destroy');

	$router->get('qurans', 'QuranController@index');
	$router->get('qurans/{id}', 'QuranController@show');
	$router->post('qurans', 'QuranController@store');
	$router->patch('qurans/{id}', 'QuranController@update');
	$router->delete('qurans/{id}', 'QuranController@destroy');
});
