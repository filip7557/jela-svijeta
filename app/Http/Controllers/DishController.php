<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dish;

class DishController extends Controller
{
    public function index()
    {
        $dishes = Dish::all();
        return response()->json($dishes);
    }
}
