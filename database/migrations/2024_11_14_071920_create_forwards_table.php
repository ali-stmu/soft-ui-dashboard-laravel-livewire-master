<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forwards', function (Blueprint $table) {
            $table->id(); // Primary key: form_id (automatically generated as id)
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('director_id');
            $table->unsignedBigInteger('reviewer_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('form_id')->references('id')->on('oric_forms')->onDelete('cascade');
            $table->foreign('director_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewer_id')->references('id')->on('reviewers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forwards');
    }
};
