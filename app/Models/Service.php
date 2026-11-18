<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Service extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'icon',
        'short_summary',
        'content',
        'featured_image_id',
        'video_url',
        'is_featured',
        'order',
        'is_active',
    ];

    protected $with = ['featuredImage'];

    protected $casts = [
        'title' => 'array',
        'short_summary' => 'array',
        'content' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'featured_image_id');
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoble');
    }

    public function getYoutubeIdAttribute(): ?string
    {
        if (empty($this->video_url)) {
            return null;
        }
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/|youtube\.com/shorts/)([^"&?/ ]{11})%i';
        if (preg_match($pattern, trim($this->video_url), $match)) {
            return $match[1];
        }
        return null;
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $id = $this->youtube_id;
        return $id ? "https://www.youtube-nocookie.com/embed/{$id}?rel=0" : null;
    }

    public function getDisplayTitleAttribute(): string
    {
        $locale = app()->getLocale();
        $val = $this->getTranslation('title', $locale);
        if (is_array($val)) {
            return $val[$locale] ?? $val[config('app.fallback_locale', 'en')] ?? reset($val) ?? '';
        }
        return (string) ($val ?? '');
    }

    public function getDisplaySummaryAttribute(): string
    {
        $locale = app()->getLocale();
        $val = $this->getTranslation('short_summary', $locale);
        if (is_array($val)) {
            return $val[$locale] ?? $val[config('app.fallback_locale', 'en')] ?? reset($val) ?? '';
        }
        return (string) ($val ?? '');
    }

    public function getDisplayContentAttribute(): string
    {
        $locale = app()->getLocale();
        $val = $this->getTranslation('content', $locale);
        if (is_array($val)) {
            return $val[$locale] ?? $val[config('app.fallback_locale', 'en')] ?? reset($val) ?? '';
        }
        return (string) ($val ?? '');
    }
}