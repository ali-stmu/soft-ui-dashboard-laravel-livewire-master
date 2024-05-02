<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->down();
        $roles = [
            'VC',
            'PS/Coordinator',
            'Dean',
            'HOD',
            'Registrar',
            'Assistant Registrar',
            'HR',
            'Employee',
            'Dispatcher',
        ];

        foreach ($roles as $role) {
            Role::create([
                'name' => $role,
            ]);
        }
    }
     /**
     * Reverse the database seeds.
     *
     * @return void
     */
    public function down()
    {
        Role::whereIn('name', [
            'VC',
            'PS/Coordinator',
            'Dean',
            'HOD',
            'Registrar',
            'Assistant Registrar',
            'HR',
            'Employee',
            'Dispatcher',
        ])->delete();
    }
}
