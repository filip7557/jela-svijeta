<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Category;

class MealController extends Controller
{
    public function index(Request $request)
    {
        $meals = Meal::all();
        $lang = "";
        $lang = $request->lang;
        //add table for supported languages
        //add check for not supported languages
        if ($lang == "")
            return response() -> json(['error' => "No language specified."]);
        return response() -> json(['data' => Meal::to_json($meals, $lang)]);
    }
}
