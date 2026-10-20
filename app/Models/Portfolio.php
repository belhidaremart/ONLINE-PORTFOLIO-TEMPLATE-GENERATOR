<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
    protected $fillable = [
        'full_name', 'age', 'email', 'contact_number', 'address', 'about',
        'facebook_link', 'profile_picture', 'template',
    ];

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}