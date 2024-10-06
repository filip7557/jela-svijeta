<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected static $id = -1;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        static::$id++;
        return [
            'id' => static::$id,
            'title' => sprintf("Category %d title in ENG", static::$id),
            'slug' => sprintf("category-%d", static::$id),
        ];
    }
}
