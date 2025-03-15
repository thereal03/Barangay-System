<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tickets = [];

        // Loop through departments 1 to 33
        for ($departmentId = 1; $departmentId <= 25; $departmentId++) {
            // Create 2 tickets for each department
            for ($i = 1; $i <= 2; $i++) {
                $tickets[] = [
                    'uuid' => Str::uuid(),
                    'subject' => "Ticket for Department $departmentId - Issue $i",
                    'status_id' => rand(1, 3), // Random status between 1 and 3
                    'priority_id' => rand(1, 4), // Random priority between 1 and 4
                    'department_id' => $departmentId, // Department ID from 1 to 33
                    'user_id' => 35, // Fixed user_id to 29
                    'agent_id' => null,
                    'closed_by' => null,
                    'service_id' => rand(1, 22), // Random service between 1 and 22
                    'closed_at' => null,
                    'created_at' => now()->subDays(rand(1, 30)), // Random creation date within the last 30 days
                    'updated_at' => now()->subDays(rand(1, 30)), // Random update date within the last 30 days
                    'needed_by' => now()->addDays(rand(1, 30))->format('Y-m-d'), // Random needed_by date within the next 30 days
                ];
            }
        }

        // Insert all tickets into the database
        DB::table('tickets')->insert($tickets);
    }
}