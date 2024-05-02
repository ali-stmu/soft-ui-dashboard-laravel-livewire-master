<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\FacultyType;

class FacultyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->down();
        // Inserting academic faculty type
        FacultyType::create([
            'name' => 'Academic',
        ]);

        // Inserting non-academic faculty type
        FacultyType::create([
            'name' => 'Non Academic',
        ]);
    }
    public function down()
    {
        FacultyType::truncate();
    }
}
