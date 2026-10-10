<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $fillable = ['portfolio_id', 'company', 'position', 'start_year', 'end_year', 'description'];
}