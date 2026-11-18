<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoGallery extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'album_id',
        'title',
        'youtube_url',
        'youtube_id',
        'thumbnail_id',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'title'       => 'array',
        'description' => 'array',
        'is_active'   => 'boolean',
        'order'       => 'integer',
    ];

    protected $with = ['thumbnail', 'album'];

    public static function extractYoutubeId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/|youtube\.com/shorts/)([^"&?/ ]{11})%i';
        if (preg_match($pattern, trim($url), $match)) {
            return $match[1];
        }

        return null;
    }

    public static function boot(): void
    {
        parent::boot();

        static::saving(function ($video) {
            if (!empty($video->youtube_url) && empty($video->youtube_id)) {
                $video->youtube_id = static::extractYoutubeId($video->youtube_url);
            }
        });
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(GalleryAlbum::class, 'album_id');
    }

    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'thumbnail_id');
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return $this->thumbnail->url;
        }

        if (!empty($this->youtube_id)) {
            return "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg";
        }

        return asset('assets/images/gallery/gallery-turbine.webp');
    }

    public function getEmbedUrlAttribute(): ?string
    {
        if (!empty($this->youtube_id)) {
            return "https://www.youtube-nocookie.com/embed/{$this->youtube_id}?rel=0";
        }

        return null;
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

    public function getDisplayDescriptionAttribute(): string
    {
        $locale = app()->getLocale();
        $val = $this->getTranslation('description', $locale);
        if (is_array($val)) {
            return $val[$locale] ?? $val[config('app.fallback_locale', 'en')] ?? reset($val) ?? '';
        }
        return (string) ($val ?? '');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
