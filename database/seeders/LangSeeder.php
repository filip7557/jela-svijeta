<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lang;
use DB;

class LangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public static $langs = ['en', 'nl', 'fr', 'de'];

    public function run(): void
    {
        DB::delete('DELETE FROM langs'); //delete whole  table
        DB::delete('DELETE FROM sqlite_sequence where name="langs"'); //reset ROWMAX for ids
        for ($i = 0; $i < count(LangSeeder::$langs); $i++) {
            $lang = Lang::factory()->create();
            $lang->lang = LangSeeder::$langs[$i];
            $lang->save();
        }
    }
}
