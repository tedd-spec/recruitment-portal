<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run()
    {
        Job::create([
            'job_code' => 'EACC-001',
            'title' => 'Senior Software Developer',
            'location' => 'Nairobi, Kenya',
            'description' => 'We are looking for a Senior Software Developer to join our dynamic team. The ideal candidate will have extensive experience in web development and a passion for creating innovative solutions.',
            'requirements' => 'Bachelor\'s degree in Computer Science or related field. 5+ years of experience in software development. Proficiency in PHP, Laravel, JavaScript, and MySQL.',
            'employment_type' => 'Full-time',
            'salary_min' => 80000,
            'salary_max' => 120000,
            'application_deadline' => now()->addDays(30),
        ]);

       
    }
}