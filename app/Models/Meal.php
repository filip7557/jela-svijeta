<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Ingredient;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Meal extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $translatedAttributes = [];
    protected $hidden = ['translations'];

    public static $lang;

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredient');
    }

    public static function to_json($meals, $lang, $with)
    {
        Meal::$lang = $lang;
        return array_map(function ($meal) use ($with) {
            $meal = Meal::where('id', $meal->id)->firstorfail();
            $new_meal = new Meal;
            $new_meal->id = $meal->id;
            $new_meal->title = $meal->translate(Meal::$lang)->title;
            $new_meal->description = $meal->translate(Meal::$lang)->description;
            if ($meal->updated_at != $meal->created_at)
                $new_meal->status = "modified";
            else
                $new_meal->status = "created";
            if (in_array("category", $with)) {
                if ($meal->category == 0)
                    $new_meal->category = NULL;
                else
                {
                    $new_meal->category = Category::where('id', $meal->category)->firstorfail()->to_json();
                }
            }
            if (in_array("tags", $with)) {
                $new_meal->tags = Tag::where('meal_id', $meal->id)->get();
            }
            if (in_array("ingredients", $with)) {
                $ingredients = $meal->ingredients;
                $new_meal->ingredients = $ingredients;
            }
            return $new_meal;
        }, $meals->all());
    }
}
