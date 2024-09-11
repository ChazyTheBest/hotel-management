<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('task_type')->insert([
            ['name' => 'Room Cleaning', 'description' => 'Cleaning and organizing guest rooms'],
            ['name' => 'Hall Cleaning', 'description' => 'Cleaning and maintaining hallways'],
            ['name' => 'Restaurant Cleaning', 'description' => 'Cleaning dining areas and kitchens'],
            ['name' => 'Maintenance', 'description' => 'Repair and maintenance tasks'],
        ]);
    }
}
