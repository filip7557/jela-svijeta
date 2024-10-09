<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory()->count(10)->create()->each(function ($tag) {
            $title = fake()->word;
            foreach (['en', 'nl', 'fr', 'de'] as $locale) {
                $tag->translateOrNew($locale)->title = "{$title} {$locale}";
            }

            $tag->save();
        });
    }
}
