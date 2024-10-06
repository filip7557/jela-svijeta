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
        $new_meals = array_map(function ($meal) {
            $new_meal = new Meal;
            $new_meal->id = $meal->id;
            $new_meal->title = $meal->title;
            $new_meal->description = $meal->description;
            if ($meal->category == 0)
                $new_meal->category = NULL;
            else
                $new_meal->category = Category::where('id', $meal->category)->firstorfail();
            if ($meal->updated_at != $meal->created_at)
                $new_meal->status = "modified";
            else
                $new_meal->status = "created";
            return $new_meal;
        }, json_decode(json_encode($meals)));
        return response() -> json(['data' => $new_meals]);
    }
}
