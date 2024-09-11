<?php

namespace Database\Seeders;

use App\Models\MattressType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MattressTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table(MattressType::getTableName())->insert([
            ['name' => 'Memory Foam', 'description' => 'Conforms to the shape of the body for personalized support.'],
            ['name' => 'Innerspring', 'description' => 'Uses a network of metal springs or coils for support.'],
            ['name' => 'Latex', 'description' => 'Made from natural or synthetic latex, offering durability and a responsive feel.'],
            ['name' => 'Hybrid', 'description' => 'Combines memory foam or latex with innerspring coils for a balanced feel.'],
            ['name' => 'Gel-Infused', 'description' => 'Memory foam or latex mattresses with gel layers to regulate temperature.'],
            ['name' => 'Adjustable Air', 'description' => 'Uses air chambers to adjust firmness for customized comfort.'],
            ['name' => 'Pillow Top', 'description' => 'Features an extra layer of padding sewn onto the top of the mattress.'],
            ['name' => 'Euro Top', 'description' => 'Similar to pillow tops but with padding flush with the edges of the mattress.'],
            ['name' => 'Box Spring', 'description' => 'A traditional support system consisting of a wooden frame with metal springs.'],
            ['name' => 'Waterbed', 'description' => 'Uses water chambers for support and can be adjusted for firmness.'],
        ]);
    }
}
