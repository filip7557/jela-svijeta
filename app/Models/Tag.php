<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meal;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Tag extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $translatedAttributes = [];

    protected $fillable = [
        'title',
        'slug',
        'meal_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'meal_id',
        'translations',
        'pivot',
    ];

    public function meal()
    {
        return $this->belongsToMany(Meal::class);
    }
}
