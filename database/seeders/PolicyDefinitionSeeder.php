<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PolicyDefinitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('room_policy_type')->insert([
            ['name' => 'Smoking', 'description' => 'No smoking allowed in the room.'],
            ['name' => 'Pets', 'description' => 'No pets allowed in the room.'],
            ['name' => 'Accessibility', 'description' => 'Accessible for guests with disabilities.'],
            ['name' => 'Noise', 'description' => 'Quiet hours from 10 PM to 8 AM.'],
            ['name' => 'Additional Guests', 'description' => 'Additional guests allowed with a fee of $20 per person.'],
            ['name' => 'Late Checkout', 'description' => 'Late checkout allowed until 2 PM with a fee of $30.'],
            ['name' => 'Party', 'description' => 'No parties or events allowed in the room.'],
            ['name' => 'Deposit', 'description' => 'Guests are required to make a deposit to ensure damaged property is paid for.'],
        ]);
    }
}
