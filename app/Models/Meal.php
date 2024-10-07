<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Tag;

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

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public static function to_json($meals)
    {
        return array_map(function ($meal) {
            $new_meal = new Meal;
            $new_meal->id = $meal->id;
            $new_meal->title = $meal->title;
            $new_meal->description = $meal->description;
            if ($meal->updated_at != $meal->created_at)
                $new_meal->status = "modified";
            else
                $new_meal->status = "created";
            if ($meal->category == 0)
                $new_meal->category = NULL;
            else
            {
                $new_meal->category = Category::where('id', $meal->category)->firstorfail()->to_json();
            }
            $new_meal->tags = Tag::where('meal_id', $meal->id)->get();
            return $new_meal;
        }, json_decode(json_encode($meals)));
    }
}
