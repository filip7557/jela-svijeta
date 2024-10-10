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

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'meal_tag');
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'meal_ingredient');
    }

    public static function to_json($meals, $lang, $with)
    {
        return array_map(function ($meal) use ($with, $lang) {
            $meal = Meal::where('id', $meal->id)->firstorfail();
            $new_meal = new Meal;
            $new_meal->id = $meal->id;
            $new_meal->title = $meal->translate($lang)->title;
            $new_meal->description = $meal->translate($lang)->description;
            if ($meal->updated_at != $meal->created_at)
                $new_meal->status = "modified";
            else
                $new_meal->status = "created";
            if (in_array("category", $with)) {
                if ($meal->category == 0)
                    $new_meal->category = NULL;
                else
                {
                    $new_meal->category = Category::where('id', $meal->category)->firstorfail()->to_json($lang);
                }
            }
            if (in_array("tags", $with)) {
                $tags = $meal->tags;
                foreach ($tags as $tag) {
                    $tag->title = $tag->translate($lang)->title;
                }
                $new_meal->tags = $tags;
            }
            if (in_array("ingredients", $with)) {
                $ingredients = $meal->ingredients;
                foreach ($ingredients as $ingredient) {
                    $ingredient->title = $ingredient->translate($lang)->title;
                }
                $new_meal->ingredients = $ingredients;
            }
            return $new_meal;
        }, $meals->all());
    }
}
