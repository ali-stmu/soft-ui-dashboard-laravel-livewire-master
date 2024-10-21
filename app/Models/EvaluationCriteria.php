<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    use HasFactory;

    // Define the table name (optional if the table name is pluralized form of the model name)
    protected $table = 'evaluation_criteria';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'receiver_id',
        'form_id',
        'form',
        'capacity_commitment_of_pi',
        'capacity_commitment_weightage',
        'capacity_commitment_score',
        'capacity_commitment_comments',
        'clear_realistic_objectives',
        'objectives_weightage',
        'objectives_score',
        'objectives_comments',
        'rationale_novelty_originality',
        'novelty_weightage',
        'novelty_score',
        'novelty_comments',
        'design_methodology_approach',
        'methodology_weightage',
        'methodology_score',
        'methodology_comments',
        'resources_facilities',
        'resources_weightage',
        'resources_score',
        'resources_comments',
        'budget_reasonability',
        'budget_weightage',
        'budget_score',
        'budget_comments',
        'grading_scale',
        'grading_description',
        'status',
        'remarks_date',
    ];

    /**
     * Define the relationship with the User model (receiver).
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Define the relationship with the Form model.
     */
    public function form()
    {
        return $this->belongsTo(OricForm::class, 'form_id');
    }
}
