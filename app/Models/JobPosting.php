<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPosting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'department',
        'employment_type',
        'location',
        'experience_level',
        'salary_range',
        'description',
        'requirements',
        'benefits',
        'deadline',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'deadline'    => 'date',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
        'order'       => 'integer',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class, 'job_posting_id')->latest();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order', 'asc');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
