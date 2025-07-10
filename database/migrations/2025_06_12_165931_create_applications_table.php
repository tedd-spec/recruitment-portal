<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->string('education_level');
            $table->text('work_experience');
            $table->text('skills');
            $table->string('resume_path')->nullable();
            $table->text('cover_letter')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'shortlisted', 'rejected', 'hired'])->default('pending');
            $table->timestamps();
            
            $table->unique(['user_id', 'job_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};