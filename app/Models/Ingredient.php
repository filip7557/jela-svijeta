<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meal;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Ingredient extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = [];

    protected $fillable = [
        'title',
        'slug',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot',
        'translations',
    ];

    public function meals()
    {
        return $this->belongsToMany(Meal::class);
    }
}
