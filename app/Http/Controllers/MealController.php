<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Category;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::all();
        return response() -> json(['data' => Meal::to_json($meals)]);
    }
}
