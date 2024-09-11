<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SetDocumentsTableAutoIncrementValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Set the auto-increment value to start from 30,000
        DB::statement('ALTER TABLE documents AUTO_INCREMENT = 30000;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, you could reset it back to 1 if needed
        DB::statement('ALTER TABLE documents AUTO_INCREMENT = 1;');
    }
}
