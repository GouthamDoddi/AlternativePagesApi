<?php

use Illuminate\Support\Facades\Route;


// Include the page routes
require __DIR__.'/api.php';


Route::get('/', function () {
    return view('welcome');
});

