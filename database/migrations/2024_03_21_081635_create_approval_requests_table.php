<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approval_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('assigned_id')->nullable();
            $table->text('remarks')->nullable();
            $table->date('signed_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'finalapproved'])->default('pending');
            $table->unsignedBigInteger('assigned_by_id')->nullable();
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign('assigned_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('assigned_by_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('approval_requests');
    }
}
