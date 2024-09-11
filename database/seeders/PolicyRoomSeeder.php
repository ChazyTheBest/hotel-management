<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PolicyRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('room_policy')->insert([
            ['room_id' => 1, 'policy_definition_id' => 'Smoking', 'notes' => 'No smoking allowed in the room.'],
            ['room_id' => 1, 'policy_definition_id' => 'Pets', 'notes' => 'No pets allowed in the room.'],
            ['room_id' => 1, 'policy_definition_id' => 'Accessibility', 'notes' => 'Accessible for guests with disabilities.'],
            ['room_id' => 2, 'policy_definition_id' => 'Noise', 'notes' => 'Quiet hours from 10 PM to 8 AM.'],
            ['room_id' => 2, 'policy_definition_id' => 'Additional Guests', 'notes' => 'Additional guests allowed with a fee of $20 per person.'],
            ['room_id' => 3, 'policy_definition_id' => 'Late Checkout', 'notes' => 'Late checkout allowed until 2 PM with a fee of $30.'],
            ['room_id' => 3, 'policy_definition_id' => 'Party', 'notes' => 'No parties or events allowed in the room.'],
        ]);
    }
}
