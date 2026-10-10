<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Portfolio extends Model
{
    protected $fillable = [
        'full_name', 'job_title', 'profile_picture', 'email', 'contact_number', 'address',
        'about_me', 'facebook_link', 'instagram_link', 'linkedin_link',
        'github_link', 'website_link', 'template',
    ];

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }
}