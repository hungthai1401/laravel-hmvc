<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

$moduleRoute = 'DummyAlias';

Route::group(['prefix' => $moduleRoute], function (Router $router) use ($moduleRoute) {
    Route::get('/', function () use ($moduleRoute) {
        return view('DummyAlias::index');
    });
});
