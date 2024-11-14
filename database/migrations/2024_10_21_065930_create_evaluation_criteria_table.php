<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvaluationCriteriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('evaluation_criteria', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('form_id');
            $table->text('form')->nullable(); // Store form-related details

            // Criteria for evaluation
            $table->text('capacity_commitment_of_pi')->nullable();
            $table->integer('capacity_commitment_weightage')->default(15);
            $table->integer('capacity_commitment_score')->nullable();
            $table->text('capacity_commitment_comments')->nullable();

            $table->text('clear_realistic_objectives')->nullable();
            $table->integer('objectives_weightage')->default(15);
            $table->integer('objectives_score')->nullable();
            $table->text('objectives_comments')->nullable();

            $table->text('rationale_novelty_originality')->nullable();
            $table->integer('novelty_weightage')->default(20);
            $table->integer('novelty_score')->nullable();
            $table->text('novelty_comments')->nullable();

            $table->text('design_methodology_approach')->nullable();
            $table->integer('methodology_weightage')->default(20);
            $table->integer('methodology_score')->nullable();
            $table->text('methodology_comments')->nullable();

            $table->text('resources_facilities')->nullable();
            $table->integer('resources_weightage')->default(10);
            $table->integer('resources_score')->nullable();
            $table->text('resources_comments')->nullable();

            $table->text('budget_reasonability')->nullable();
            $table->integer('budget_weightage')->default(20);
            $table->integer('budget_score')->nullable();
            $table->text('budget_comments')->nullable();

            // Grading scale
            $table->string('grading_scale', 50)->nullable();
            $table->text('grading_description')->nullable();

            $table->string('status')->nullable();
            $table->timestamps();
            $table->date('remarks_date')->nullable();

            // Foreign key constraints
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('form_id')->references('id')->on('oric_forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_criteria');
    }
}
