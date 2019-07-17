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

$router->get('/api/cities', 'MainController@all');
$router->get('/api/city/{id}', 'MainController@getCity');
$router->get('/api/city/recordid/{id}', 'MainController@getCityByRecord');
$router->delete('/api/city/{id}', 'MainController@deleteCity');



