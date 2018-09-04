<?php

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

$router->get('/key', function () {
    return str_random(32);
});


$router->group(['middleware' => 'check'], function ()  use ($router) {
    // $router->get('/login' ,'AuthController@index');
    $router->post('/login','AuthController@login');
    $router->post('/register','AuthController@register');
});

$router->get('/login' ,'AuthController@index');

// $router->group(['middleware' => ['check','jwt.auth']], function ()  use ($router) {
    
//     $router->post('/login','AuthController@login');
//     $router->post('/register','AuthController@register');
// });

// $router->post('/test',function () {

//     return "555";
// });
$router->post('/test','AuthController@test');
// Route::group('middleware' => ['auth.basic', 'auth.admin']], function() {});




