<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meal;
use DB;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::delete('DELETE FROM meals'); //delete whole  table
        DB::delete('DELETE FROM meal_ingredient'); //delete whole  table
        DB::delete('DELETE FROM meal_tag'); //delete whole  table
        DB::delete('DELETE FROM sqlite_sequence where name="meals"'); //reset ROWMAX for ids
        Meal::factory()->count(5)->create()->each(function ($meal) {
            $number_of_ingredients = rand(0, 4);
            for ($i = 0; $i < $number_of_ingredients; $i++) {
                $meal->ingredients()->attach(rand(1, 10));
            }
            $number_od_tags = rand(0, 3);
            for ($i = 0; $i < $number_od_tags; $i++) {
                $meal->tags()->attach(rand(1, 10));
            }
            $title = fake()->word;
            $description = fake()->text;
            foreach (['en', 'nl', 'fr', 'de'] as $locale) {
                $meal->translateOrNew($locale)->title = "{$title} {$locale}";
                $meal->translateOrNew($locale)->description = "{$description} {$locale}";
            }

            $meal->save();
        });
    }
}
