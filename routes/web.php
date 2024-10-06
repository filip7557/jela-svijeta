<?php

use Illuminate\Support\Facades\Route;
use App\Models\Meal;

Route::get('/', function () {
    //get filtered ones and return
    return Meal::all();
});

Route::get('/greeting', function () {
    return 'Hello World!';
});
