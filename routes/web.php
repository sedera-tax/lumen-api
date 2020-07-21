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

//List product
$router->get('products', ['uses' => 'ProductController@index']);

//Add product
$router->post('products', ['uses' => 'ProductController@create']);

//Add items for product
$router->post('products/items', ['uses' => 'ProductController@addItems']);

//update product
$router->put('/product/{id}', ['uses' => 'ProductController@update']);
//update product set price
$router->put('/product/{id}/price', ['uses' => 'ProductController@setProductPrice']);

//get price
$router->get('/product/{id}/price', ['uses' => 'ProductController@getProductPrice']);

//Add order
$router->post('orders', ['uses' => 'OrderController@create']);

//Alert product expired in 48H
$router->get('alert-products', ['uses' => 'CronController@alertExpiredProduct']);
