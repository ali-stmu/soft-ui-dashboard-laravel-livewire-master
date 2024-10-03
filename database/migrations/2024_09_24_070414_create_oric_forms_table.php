<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOricFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oric_forms', function (Blueprint $table) {
            $table->id();
            $table->string('project_title');
            $table->date('expected_start_date');
            $table->string('duration_of_project'); // Assuming it's in months or another unit
            $table->decimal('total_fund_requested', 15, 2); // Adjust precision as needed

            // PI details
            $table->string('pi_name');
            $table->string('pi_designation');
            $table->string('pi_email');
            $table->string('pi_mobile');
            $table->string('pi_landline')->nullable();
            $table->string('pi_department');
            $table->string('pi_institution');

            // Co-PI details
            $table->string('co_pi_name')->nullable();
            $table->string('co_pi_designation')->nullable();
            $table->string('co_pi_department')->nullable();
            $table->string('co_pi_institution')->nullable();

            // IRB Approval details
            $table->string('irb_approval_number')->nullable();
            $table->string('attachment_irb_and_ec')->nullable();
            $table->string('irb_ec_approval_letter_certificate')->nullable();

            // Research details
            $table->text('significance_answer')->nullable();
            $table->text('distinct_value_answer')->nullable();
            $table->text('research_plan_answer')->nullable();
            $table->text('aims_and_objectives')->nullable();
            $table->text('milestones_and_deliverables')->nullable();
            $table->string('work_plan_attachment')->nullable();
            $table->text('economic_significance')->nullable();

            // Financial request
            $table->text('financial_request')->nullable();

            // User who initiated the form
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oric_forms');
    }
}
