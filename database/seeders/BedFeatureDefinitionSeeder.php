<?php

namespace Database\Seeders;

use App\Models\BedFeatureDefinition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BedFeatureDefinitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table(BedFeatureDefinition::getTableName())->insert([
            ['name' => 'Headboard', 'description' => 'A panel or framework positioned at the head of the bed.'],
            ['name' => 'Footboard', 'description' => 'A panel or framework positioned at the foot of the bed.'],
            ['name' => 'Adjustable Base', 'description' => 'Allows the bed to be adjusted for different positions (e.g., head or foot elevation).'],
            ['name' => 'Storage Drawers', 'description' => 'Drawers integrated into the bed frame for additional storage.'],
            ['name' => 'Canopy', 'description' => 'A bed with posts at each corner supporting a canopy for privacy and decoration.'],
            ['name' => 'Sleigh Bed', 'description' => 'Features a curved or scrolled headboard and footboard.'],
            ['name' => 'Platform Bed', 'description' => 'Low-profile bed with a solid or slatted base that supports the mattress without a box spring.'],
            ['name' => 'Bed Frame Material', 'description' => 'Material of the bed frame, which can be wood, metal, or upholstered fabric.'],
            ['name' => 'Bed Skirt', 'description' => 'A decorative piece that hangs from the bed frame, concealing the space under the bed.'],
            ['name' => 'Built-in Lighting', 'description' => 'Integrated lights within the bed frame or headboard.'],
            ['name' => 'Rollaway Bed', 'description' => 'A portable bed that folds up for easy storage and extra accommodations.'],
            ['name' => 'Murphy Bed', 'description' => 'A bed that folds up into the wall or a cabinet to save space.'],
        ]);
    }
}
