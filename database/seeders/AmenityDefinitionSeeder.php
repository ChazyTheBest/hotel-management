<?php

namespace Database\Seeders;

use App\Models\AmenityDefinition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenityDefinitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table(AmenityDefinition::getTableName())->insert([
            ['name' => 'Wi-Fi', 'description' => 'High-speed internet access'],
            ['name' => 'Air Conditioning', 'description' => 'Climate control system'],
            ['name' => 'TV', 'description' => 'Television with cable channels'],
            ['name' => 'Minibar', 'description' => 'Mini refrigerator with beverages'],
            ['name' => 'Safe', 'description' => 'In-room safe for valuables'],
            ['name' => 'Hair Dryer', 'description' => 'Hair drying appliance'],
        ]);
    }
}
