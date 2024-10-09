<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $translatedAttributes = [];
    protected $hidden = ['translations'];

    protected $fillable = [
        'title',
        'slug',
    ];

    public function to_json($lang)
    {
        $new_category = new Category;
        $new_category->id = $this->id;
        $new_category->title = $this->translate($lang)->title;
        $new_category->slug = $this->slug;
        return $new_category;
    }
}
