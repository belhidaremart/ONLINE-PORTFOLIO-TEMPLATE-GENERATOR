<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('profile_picture')->nullable();
            $table->string('email');
            $table->string('contact_number', 30)->nullable();
            $table->string('address')->nullable();
            $table->text('about_me')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('github_link')->nullable();
            $table->string('website_link')->nullable();
            $table->string('template', 20)->default('simple');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};