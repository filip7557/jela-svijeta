<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Meal;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'meal_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'meal_id',
    ];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
