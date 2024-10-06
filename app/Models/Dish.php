<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Tag;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'category',
    ];

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
