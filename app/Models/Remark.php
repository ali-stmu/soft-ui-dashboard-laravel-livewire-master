<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remark extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'director_id', 'initiator_id', 'form_id'];

    /**
     * Get the director associated with the remark.
     */
    public function director()
    {
        return $this->belongsTo(User::class, 'director_id');
    }

    /**
     * Get the initiator associated with the remark.
     */
    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiator_id');
    }

    /**
     * Get the ORIC form associated with the remark.
     */
    public function oricForm()
    {
        return $this->belongsTo(OricForm::class, 'form_id');
    }
}
