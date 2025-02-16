<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Ensure Admin user exists
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'role_id' => 1, // Assuming 1 is for admin
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        // Barangay users
        $barangays = [
            'Amsic', 'Anunas', 'Balibago', 'Capaya', 'Claro M. Recto', 'Cuayan',
            'Cutcut', 'Lourdes North West', 'Lourdes Sur', 'Lourdes Sur East',
            'Malabanias', 'Margot', 'Mining', 'Pandn', 'Pampang', 'Pulungbulu',
            'Pulung Cacutud', 'Sapangbato', 'San Jose', 'San Nicolas',
            'Sta. Teresita', 'Sto. Cristo', 'Sto. Domingo', 'Sto. Rosario',
            'Virgen Delos Remedios'
        ];

        foreach ($barangays as $barangay) {
            $email = strtolower(str_replace(' ', '', $barangay)) . '@barangay.com';

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => 'Barangay ' . $barangay,
                    'password' => Hash::make('12345678'), // Default password
                    'role_id' => 4, // Change this if needed (assuming 2 is for barangay officials)
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}