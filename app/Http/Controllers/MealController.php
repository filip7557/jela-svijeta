<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\Category;
use App\Models\Lang;
use App\Models\Tag;

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

        $category = $request->category;
        if ($category != "") {
            if ($category == "!NULL") {
                $meals = $meals->filter(function ($meal) {
                    return $meal->category != NULL;
                });
            }
            else {
                $meals = $meals->filter(function ($meal) use ($category) {
                    if ($category == "NULL")
                        $category = 0;
                    return $meal->category == $category;
                });
            }
        }

        $tags = $request->tags;
        if ($tags != "") {
            $tags = explode(",", $tags);
            for ($i = 0; $i < count($tags); $i++) {
                $tags[$i] = intval($tags[$i], 10);
            }
            $meals = $meals->filter(function ($meal) use ($tags) {
                foreach (Tag::where('meal_id', $meal->id)->get() as $tag) {
                    $bool = in_array($tag->id, $tags);
                    if ($bool == false)
                        return false;
                }
                return true;
            });
        }

        $with = $request->with;
        if ($with != "") {
            $with = explode(",", $with);
        }
        else
            $with = [];

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

        $totalPages = floor((count($meals) / $per_page));
        if ($totalPages == 0)
            $totalPages = 1;
        return response() -> json([
            'meta' => [
                'currentPage' => $page,
                'totalItems' => count($meals),
                'itemPerPage' => $per_page,
                'totalPages' => $totalPages,
            ],
            'data' => Meal::to_json($new_meals, $lang, $with)
        ]);
    }
}
