<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resident;

class ResidentSeeder extends Seeder
{
    public function run()
    {
        $residents = [
            [
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'dob' => '1995-05-15',
                'gender' => 'male',
                'address' => '123 Rizal St, Barangay Balibago, Angeles City',
                'contact_number' => '09123456781',
                'email' => 'juan.delacruz@example.com',
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'dob' => '1992-08-20',
                'gender' => 'female',
                'address' => '456 Magsaysay Ave, Barangay Cutcut, Angeles City',
                'contact_number' => '09123456782',
                'email' => 'maria.santos@example.com',
            ],
            [
                'first_name' => 'Pedro',
                'last_name' => 'Gonzalez',
                'dob' => '1988-12-10',
                'gender' => 'male',
                'address' => '789 Mabini St, Barangay Pandan, Angeles City',
                'contact_number' => '09123456783',
                'email' => 'pedro.gonzalez@example.com',
            ],
            [
                'first_name' => 'Ana',
                'last_name' => 'Reyes',
                'dob' => '2000-03-25',
                'gender' => 'female',
                'address' => '321 Bonifacio St, Barangay Malabanias, Angeles City',
                'contact_number' => '09123456784',
                'email' => 'ana.reyes@example.com',
            ],
            [
                'first_name' => 'Carlos',
                'last_name' => 'Lopez',
                'dob' => '1997-07-18',
                'gender' => 'male',
                'address' => '654 P. Burgos St, Barangay Pulung Maragul, Angeles City',
                'contact_number' => '09123456785',
                'email' => 'carlos.lopez@example.com',
            ],
            [
                'first_name' => 'Isabel',
                'last_name' => 'Torres',
                'dob' => '1993-04-05',
                'gender' => 'female',
                'address' => '987 Luna St, Barangay Sapalibutad, Angeles City',
                'contact_number' => '09123456786',
                'email' => 'isabel.torres@example.com',
            ],
            [
                'first_name' => 'Ricardo',
                'last_name' => 'Fernandez',
                'dob' => '1989-11-30',
                'gender' => 'male',
                'address' => '147 Quezon Blvd, Barangay Sto. Domingo, Angeles City',
                'contact_number' => '09123456787',
                'email' => 'ricardo.fernandez@example.com',
            ],
            [
                'first_name' => 'Sofia',
                'last_name' => 'Cruz',
                'dob' => '1996-02-14',
                'gender' => 'female',
                'address' => '258 Del Pilar St, Barangay Pulung Cacutud, Angeles City',
                'contact_number' => '09123456788',
                'email' => 'sofia.cruz@example.com',
            ],
            [
                'first_name' => 'Andres',
                'last_name' => 'Navarro',
                'dob' => '1994-06-21',
                'gender' => 'male',
                'address' => '369 Roxas St, Barangay Mining, Angeles City',
                'contact_number' => '09123456789',
                'email' => 'andres.navarro@example.com',
            ],
            [
                'first_name' => 'Elena',
                'last_name' => 'Gutierrez',
                'dob' => '1990-09-10',
                'gender' => 'female',
                'address' => '741 Aguinaldo St, Barangay Margot, Angeles City',
                'contact_number' => '09123456790',
                'email' => 'elena.gutierrez@example.com',
            ],
            [
                'first_name' => 'Javier',
                'last_name' => 'Ortega',
                'dob' => '1985-12-05',
                'gender' => 'male',
                'address' => '852 San Pedro St, Barangay Capaya, Angeles City',
                'contact_number' => '09123456791',
                'email' => 'javier.ortega@example.com',
            ],
            [
                'first_name' => 'Carmen',
                'last_name' => 'Del Rosario',
                'dob' => '1998-08-08',
                'gender' => 'female',
                'address' => '963 Villamor St, Barangay Salapungan, Angeles City',
                'contact_number' => '09123456792',
                'email' => 'carmen.delrosario@example.com',
            ],
            [
                'first_name' => 'Emilio',
                'last_name' => 'Villanueva',
                'dob' => '1991-01-03',
                'gender' => 'male',
                'address' => '159 Quirino St, Barangay Claro M. Recto, Angeles City',
                'contact_number' => '09123456793',
                'email' => 'emilio.villanueva@example.com',
            ],
            [
                'first_name' => 'Beatriz',
                'last_name' => 'Jimenez',
                'dob' => '1999-10-15',
                'gender' => 'female',
                'address' => '357 MacArthur Hwy, Barangay Agapito Del Rosario, Angeles City',
                'contact_number' => '09123456794',
                'email' => 'beatriz.jimenez@example.com',
            ],
            [
                'first_name' => 'Gabriel',
                'last_name' => 'Morales',
                'dob' => '1986-07-22',
                'gender' => 'male',
                'address' => '753 Zamora St, Barangay Lourdes North West, Angeles City',
                'contact_number' => '09123456795',
                'email' => 'gabriel.morales@example.com',
            ],
        ];

        foreach ($residents as $resident) {
            Resident::create($resident);
        }
    }
}
