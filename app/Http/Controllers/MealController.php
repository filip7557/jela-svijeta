<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Category;
use App\Models\Lang;

class MealController extends Controller
{
    public function index(Request $request)
    {
        $meals = Meal::where('status', 'created')->get();
        
        $lang = "";
        $lang = $request->lang;
        $supported_langs = [];
        $langs = Lang::all();
        foreach ($langs as $new_lang) {
            array_push($supported_langs, $new_lang->lang);
        }

        $page = $request->page;
        if ($page == "")
            $page = 1;

        $per_page = $request->per_page;
        if ($per_page == "")
            $per_page = count($meals);
        $new_meals = $meals->slice(floor(($page-1)*$per_page), $per_page);


        if ($lang == "")
            return response() -> json(['error' => "No language specified."]);
        if (!in_array($lang, $supported_langs))
            return response() -> json(['error' => "Specified language not supported."]);
        return response() -> json([
            'meta' => [
                'currentPage' => $page,
                'totalItems' => count($meals),
                'itemPerPage' => $per_page,
                'totalPages' => floor((count($meals) / $per_page)),
            ],
            'data' => Meal::to_json($new_meals, $lang)
        ]);
    }
}
