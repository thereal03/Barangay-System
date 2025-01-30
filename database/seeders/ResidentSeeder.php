<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resident;

class ResidentSeeder extends Seeder
{
    public function run()
    {
        // Example of creating multiple residents
        Resident::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'dob' => '1990-01-01',
            'gender' => 'male',
            'address' => '123 Main St',
            'contact_number' => '09123456789',
            'email' => 'johndoe@example.com',
        ]);

        // You can also use a factory to generate random data
        // Resident::factory()->count(10)->create();
    }
}
