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

$router->get('testing', function () {
	return "testing";
});


$router->get('users', 'UserController@index');
$router->get('users/{id}', 'UserController@show');
$router->post('users', "UserController@store");
$router->put('users/{id}', "UserController@update");
$router->delete('users/{id}', "UserController@destroy");

// $router->get("user", ["middleware" => "auth:api", "uses" => "UserController@login"]);
// $router->post('/login', function (Request $request) {
//     $token = app('auth')->attempt($request->only('username', 'password'));

//     return response()->json(compact('token'));
// });
$router->post('login', "AuthController@login");


$router->get('/me', function (Request $request) {
    return $request->user();
});
