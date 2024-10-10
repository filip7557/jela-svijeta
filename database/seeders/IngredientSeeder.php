<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::delete('DELETE FROM ingredients');
        DB::delete('DELETE FROM sqlite_sequence where name="ingredients"');
        Ingredient::factory()->count(10)->create()->each(function ($ingredient) {
            $title = fake()->word;
            foreach (['en', 'nl', 'fr', 'de'] as $locale) {
                $ingredient->translateOrNew($locale)->title = "{$title} {$locale}";
            }

            $ingredient->save();
        });;
    }
}
