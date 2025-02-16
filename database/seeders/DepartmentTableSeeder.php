<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use Carbon\Carbon;

class DepartmentTableSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'Amsic', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Anunas', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Balibago', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Capaya', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Claro M. Recto', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Cuayan', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Cutcut', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Lourdes North West', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Lourdes Sur', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Lourdes Sur East', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Malabanias', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Margot', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Mining', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Pandn', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Pampang', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Pulungbulu', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Pulung Cacutud', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Sapangbato', 'all_agents' => 1, 'public' => 1],
            ['name' => 'San Jose', 'all_agents' => 1, 'public' => 1],
            ['name' => 'San Nicolas', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Sta. Teresita', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Sto. Cristo', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Sto. Domingo', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Sto. Rosario', 'all_agents' => 1, 'public' => 1],
            ['name' => 'Virgen Delos Remedios', 'all_agents' => 1, 'public' => 1],
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate(
                ['name' => $department['name']],
                [
                    'all_agents' => $department['all_agents'],
                    'public' => $department['public'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }
}
