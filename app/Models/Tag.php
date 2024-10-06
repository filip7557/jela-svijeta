<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dish;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
    ];

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
