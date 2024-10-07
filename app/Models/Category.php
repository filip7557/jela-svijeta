<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
    ];

    public function to_json()
    {
        $new_category = new Category;
        $new_category->id = $this->id;
        $new_category->title = $this->title;
        $new_category->slug = $this->slug;
        return $new_category;
    }
}
