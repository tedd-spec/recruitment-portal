<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'education_level',
        'work_experience',
        'skills',
        'resume_path',
        'cover_letter',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getStatusBadgeClassAttribute()
    {
        $badges = [
            'pending' => 'badge-warning',
            'reviewed' => 'badge-info',
            'shortlisted' => 'badge-success',
            'rejected' => 'badge-danger',
            'hired' => 'badge-primary'
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }
}