<?php

use Illuminate\Support\Facades\Route;
use App\Models\Dish;

Route::get('/', function () {
    //get filtered ones and return
    return Dish::all();
});

Route::get('/greeting', function () {
    return 'Hello World!';
});
