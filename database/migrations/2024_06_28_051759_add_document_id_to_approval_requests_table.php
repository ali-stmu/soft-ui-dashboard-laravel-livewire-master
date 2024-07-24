<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentIdToApprovalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('approval_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable();

            // If you want to add a foreign key constraint
            // $table->foreign('department_id')->references('id')->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('approval_requests', function (Blueprint $table) {
            // Drop the foreign key constraint if it was added
            // $table->dropForeign(['department_id']);

            $table->dropColumn('department_id');
        });
    }
}
