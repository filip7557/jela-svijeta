<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Ingredient;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'category',
    ];

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredient');
    }

    public static function to_json($meals, $request)
    {
        if ($request->lang != NULL)
            $lang = $request->lang;
        else
            $lang = 'en';
        return array_map(function ($meal) {
            $new_meal = new Meal;
            $new_meal->id = $meal->id;
            $new_meal->title = $meal->getTranslation(lang)->title;
            $new_meal->description = $meal->getTranslation(lang)->description;
            if ($meal->updated_at != $meal->created_at)
                $new_meal->status = "modified";
            else
                $new_meal->status = "created";
            if ($meal->category == 0)
                $new_meal->category = NULL;
            else
            {
                $new_meal->category = Category::where('id', $meal->category)->firstorfail()->getTranslation(lang)->to_json();
            }
            $new_meal->tags = Tag::where('meal_id', $meal->id)->get()->getTranslation(lang);
            $ingredients = Meal::where('id', $meal->id)->get()->firstorfail()->getTranslation(lang)->ingredients;
            $new_meal->ingredients = $ingredients;
            return $new_meal;
        }, json_decode(json_encode($meals)));
    }
}
