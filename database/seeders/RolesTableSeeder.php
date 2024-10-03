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
            ['id' => 1, 'name' => 'VC'],
            ['id' => 2, 'name' => 'PS/Coordinator'],
            ['id' => 3, 'name' => 'Dean'],
            ['id' => 4, 'name' => 'HOD'],
            ['id' => 5, 'name' => 'Registrar'],
            ['id' => 6, 'name' => 'Assistant Registrar'],
            ['id' => 7, 'name' => 'HR'],
            ['id' => 8, 'name' => 'Employee'],
            ['id' => 9, 'name' => 'Dispatcher'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }

    /**
     * Reverse the database seeds.
     *
     * @return void
     */
    public function down()
    {
        Role::whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9])->delete();
    }
}
