<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remarks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('director_id');
            $table->unsignedBigInteger('initiator_id');
            $table->timestamps();

            // Add foreign key constraints if needed
            $table->foreign('director_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('initiator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remarks');
    }
}
