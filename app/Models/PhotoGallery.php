<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PhotoGallery extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'album_id',
        'media_id',
        'title',
        'caption',
        'order',
        'is_active',
    ];

    protected $casts = [
        'title'     => 'array',
        'caption'   => 'array',
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    protected $with = ['media', 'album'];

    public function album(): BelongsTo
    {
        return $this->belongsTo(GalleryAlbum::class, 'album_id');
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'media_id');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->media?->url ?? asset('assets/images/gallery/gallery-turbine.webp');
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

    public function getDisplayCaptionAttribute(): string
    {
        $locale = app()->getLocale();
        $val = $this->getTranslation('caption', $locale);
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
