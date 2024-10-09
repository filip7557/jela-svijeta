<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::delete('DELETE FROM categories');
        DB::delete('DELETE FROM sqlite_sequence where name="categories"');
        Category::factory()->count(4)->create()->each(function ($category) {
            $title = fake()->word;
            foreach (['en', 'nl', 'fr', 'de'] as $locale) {
                $category->translateOrNew($locale)->title = "{$title} {$locale}";
            }

            $category->save();
        });
    }
}
