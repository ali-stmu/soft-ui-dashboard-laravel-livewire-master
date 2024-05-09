<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Make 'description' column nullable
            $table->string('description')->nullable()->change();
            
            // Make 'attachment' column nullable
            $table->string('attachment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // If you want to revert the changes, you can make the columns non-nullable again
            $table->string('description')->nullable(false)->change();
            $table->string('attachment')->nullable(false)->change();
        });
    }
};
