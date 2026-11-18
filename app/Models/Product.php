<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'part_number',
        'technical_specifications',
        'category_id',
        'brand_id',
        'featured_image_id',
        'gallery_image_ids',
        'brochure_media_id',
        'is_active',
    ];

    protected $with = ['featuredImage', 'category', 'brand'];

    protected $casts = [
        'title'                    => 'array',
        'technical_specifications' => 'array',
        'gallery_image_ids'        => 'array',
        'is_active'                => 'boolean',
    ];

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'featured_image_id');
    }

    public function brochure(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'brochure_media_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoble');
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

    public function getCategoryAttribute(): string
    {
        if ($this->relationLoaded('category')) {
            $cat = $this->getRelation('category');
            if ($cat && isset($cat->name)) {
                return $cat->name;
            }
        }
        return $this->technical_specifications['category'] ?? 'Turbocharger Spare Parts';
    }

    public function getBrandAttribute(): string
    {
        if ($this->relationLoaded('brand')) {
            $brand = $this->getRelation('brand');
            if ($brand && isset($brand->name)) {
                return $brand->name;
            }
        }
        return $this->technical_specifications['brand'] ?? 'Multi-Brand OEM';
    }

    public function getCompatibleModelsAttribute(): string
    {
        return $this->technical_specifications['compatible_models'] ?? 'Marine & Industrial Turbochargers';
    }

    public function getConditionAttribute(): string
    {
        return $this->technical_specifications['condition'] ?? 'Genuine New OEM';
    }

    public function getStockStatusAttribute(): string
    {
        return $this->technical_specifications['stock_status'] ?? 'In Stock (Central Warehouse)';
    }

    public function getLeadTimeAttribute(): string
    {
        return $this->technical_specifications['lead_time'] ?? '24-48 Hours Port Dispatch';
    }

    public function getWarrantyAttribute(): string
    {
        return $this->technical_specifications['warranty'] ?? '12 Months Class Certified Warranty';
    }

    public function getSummaryAttribute(): string
    {
        $val = $this->technical_specifications['summary'] ?? ($this->technical_specifications['short_description'] ?? '');
        if (is_array($val)) {
            $locale = app()->getLocale();
            return $val[$locale] ?? $val[config('app.fallback_locale', 'en')] ?? reset($val) ?? '';
        }
        return (string) $val;
    }

    public function getDescriptionAttribute(): string
    {
        $val = $this->technical_specifications['description'] ?? '';
        if (is_array($val)) {
            $locale = app()->getLocale();
            return $val[$locale] ?? $val[config('app.fallback_locale', 'en')] ?? reset($val) ?? '';
        }
        return (string) $val;
    }

    public function getSpecsListAttribute(): array
    {
        return $this->technical_specifications['specs'] ?? [];
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->relationLoaded('featuredImage')) {
            return $this->featuredImage?->url ?? asset('assets/images/gallery/gallery-turbine.webp');
        }

        return $this->featured_image_id
            ? ($this->featuredImage?->url ?? asset('assets/images/gallery/gallery-turbine.webp'))
            : asset('assets/images/gallery/gallery-turbine.webp');
    }

    public function getPdfUrlAttribute(): ?string
    {
        if ($this->relationLoaded('brochure')) {
            return $this->brochure?->url ?? ($this->technical_specifications['pdf_url'] ?? null);
        }

        return $this->brochure_media_id
            ? ($this->brochure?->url ?? ($this->technical_specifications['pdf_url'] ?? null))
            : ($this->technical_specifications['pdf_url'] ?? null);
    }

    /**
     * Get Collection of gallery MediaAsset objects preserving order.
     */
    public function getGalleryImagesAttribute()
    {
        $ids = $this->gallery_image_ids ?? ($this->technical_specifications['gallery_image_ids'] ?? []);
        if (empty($ids) || !is_array($ids)) {
            return collect();
        }

        $assets = MediaAsset::whereIn('id', $ids)->get()->keyBy('id');
        return collect($ids)->map(fn($id) => $assets->get($id))->filter()->values();
    }

    /**
     * Get all images (featured image + gallery images).
     */
    public function getAllImagesAttribute()
    {
        $images = collect();
        if ($this->featuredImage) {
            $images->push($this->featuredImage);
        }
        foreach ($this->gallery_images as $img) {
            if (!$images->contains('id', $img->id)) {
                $images->push($img);
            }
        }
        return $images;
    }
}