<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OricFormStatusSeeder extends Seeder
{
    
    public function run()
    {
        $this->down();
        DB::table('oric_form_status')->insert([
            ['title' => 'InReview'],
            ['title' => 'Accepted'],
            ['title' => 'Rejected'],
            ['title' => 'Submitted'],
        ]);
    }

    // Method to clear the data for rollback or reset purposes
    public function down()
    {
        DB::table('oric_form_status')->truncate();
    }
}
