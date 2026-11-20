<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_posting_id',
        'full_name',
        'email',
        'phone',
        'resume_path',
        'cover_letter',
        'payload',
        'status',
        'admin_notes',
        'ip_address',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function jobPosting(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class, 'job_posting_id');
    }

    public function getResumeUrlAttribute(): ?string
    {
        if (empty($this->resume_path)) {
            return null;
        }

        return asset('storage/' . ltrim($this->resume_path, '/'));
    }

    public function scopeStatus($query, string $status)
    {
        if ($status !== 'all') {
            return $query->where('status', $status);
        }
        return $query;
    }
}
