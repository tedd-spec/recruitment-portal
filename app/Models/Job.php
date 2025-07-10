<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_code',
        'title',
        'location',
        'description',
        'requirements',
        'employment_type',
        'salary_min',
        'salary_max',
        'application_deadline',
        'is_active'
    ];

    protected $casts = [
        'application_deadline' => 'date',
        'is_active' => 'boolean',
        'salary_min' => 'decimal:2',
        'salary_max' => 'decimal:2'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFormattedSalaryAttribute()
    {
        if ($this->salary_min && $this->salary_max) {
            return '$' . number_format($this->salary_min) . ' - $' . number_format($this->salary_max);
        }
        return 'Competitive';
    }
}