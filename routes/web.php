<?php

use \App\Http\Controllers\ctrlFinanController;
use \App\Http\Controllers\CategoryController;
use \App\Http\Controllers\PaymentService;
use \App\Http\Controllers\UserService;
use FastRoute\Route;

$router->group(['prefix' => "/api/v1/user/"], function() use ($router){
    $router -> post("login", "AuthController@login");
    $router -> post("create", "userController@createUser");
});

$router->group(['prefix' => "/api/v1/ctrlF"], function() use ($router){
    $router -> get("/{month}/{user}", "ctrlFinanController@getAll");
    $router -> get("/Details/{id}/{user}", "ctrlFinanController@get");
    $router -> post("/", "ctrlFinanController@create");
    $router -> put("/{id}", "ctrlFinanController@Update");
    $router -> post("/updateStatus/{id}/{user}", "ctrlFinanController@updateStatus");
    $router -> delete("/{id}", "ctrlFinanController@Delete");
});

$router->group(['prefix' => "/api/v1/category/"], function() use ($router){
    $router -> get("", "CategoryController@getAll");
    $router -> get("{id}", "CategoryController@get");
    $router -> post("", "CategoryController@create");
    $router -> put("", "CategoryController@Update");
    $router -> delete("{id}", "CategoryController@Delete");
});

$router->group(['prefix' => "/api/v1/payment"], function() use ($router){
    $router -> get("/{user}", "PaymentController@getAll");
    $router -> get("/Details/{id}/{user}", "PaymentController@get");
    $router -> post("/", "PaymentController@create");
    $router -> put("/{id}/{user}", "PaymentController@update");
    $router -> delete("/{id}/{user}", "PaymentController@delete");
});
