<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('room_type')->insert([
            ['name' => 'Single'],
            ['name' => 'Double'],
            ['name' => 'Suite'],
            ['name' => 'Deluxe'],
            ['name' => 'Family'],
            ['name' => 'Executive'],
            ['name' => 'Presidential'],
            ['name' => 'Bunk Bed'],
            ['name' => 'Studio'],
            ['name' => 'Penthouse'],
        ]);
    }
}
