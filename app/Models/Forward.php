<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forward extends Model
{
    use HasFactory;

    // Specify the table name (optional if it follows Laravel's naming convention)
    protected $table = 'forwards';

    // Define fillable fields to allow mass assignment
    protected $fillable = [
        'form_id',
        'director_id',
        'reviewer_id',
    ];

    /**
     * Relationship to the ORIC form.
     */
    public function form()
    {
        return $this->belongsTo(OricForm::class, 'form_id');
    }

    /**
     * Relationship to the director (user).
     */
    public function director()
    {
        return $this->belongsTo(User::class, 'director_id');
    }

    /**
     * Relationship to the reviewer.
     */
    public function reviewer()
    {
        return $this->belongsTo(Reviewer::class, 'reviewer_id');
    }
}
