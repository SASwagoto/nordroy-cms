<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryAlbum extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image_id',
        'type',
        'order',
        'is_active',
    ];

    protected $casts = [
        'name'        => 'array',
        'description' => 'array',
        'is_active'   => 'boolean',
        'order'       => 'integer',
    ];

    protected $with = ['coverImage'];

    public function coverImage(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'cover_image_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(PhotoGallery::class, 'album_id')->orderBy('order');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(VideoGallery::class, 'album_id')->orderBy('order');
    }

    public function getDisplayNameAttribute(): string
    {
        $locale = app()->getLocale();
        $val = $this->getTranslation('name', $locale);
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
