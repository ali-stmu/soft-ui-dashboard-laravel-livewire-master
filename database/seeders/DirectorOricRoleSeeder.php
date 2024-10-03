<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DirectorOricRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Add the role "Director ORIC" with ID 10
        $this->down();
        Role::create([
            'id' => 10,
            'name' => 'Director ORIC',
        ]);
    }

    /**
     * Reverse the database seeds.
     *
     * @return void
     */
    public function down()
    {
        // Delete the role "Director ORIC" with ID 10
        Role::where('id', 10)->delete();
    }
}
