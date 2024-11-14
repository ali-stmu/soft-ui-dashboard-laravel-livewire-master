<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Reviewer extends Authenticatable
{
    use HasFactory;
    protected $table = 'reviewers';
    protected $fillable = [
        'name', 
        'email', 
        'designation', 
        'institute_name', 
        'country', 
        'password',
    ];
}
