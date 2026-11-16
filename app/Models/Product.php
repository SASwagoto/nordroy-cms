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
        'featured_image_id',
        'brochure_media_id',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'technical_specifications' => 'array',
        'is_active' => 'boolean',
    ];

    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'featured_image_id');
    }

    public function brochure(): BelongsTo
    {
        return $this->belongsTo(MediaAsset::class, 'brochure_media_id');
    }

    public function seo(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoble');
    }

    public function getDisplayTitleAttribute(): string
    {
        $val = $this->getTranslation('title');
        if (is_array($val)) {
            return $val['en'] ?? reset($val) ?? '';
        }
        return (string) ($val ?? '');
    }

    public function getCategoryAttribute(): string
    {
        return $this->technical_specifications['category'] ?? 'Turbocharger Spare Parts';
    }

    public function getBrandAttribute(): string
    {
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
        return $this->technical_specifications['summary'] ?? ($this->technical_specifications['short_description'] ?? '');
    }

    public function getDescriptionAttribute(): string
    {
        return $this->technical_specifications['description'] ?? '';
    }

    public function getSpecsListAttribute(): array
    {
        return $this->technical_specifications['specs'] ?? [];
    }

    public function getImageUrlAttribute(): string
    {
        return $this->featuredImage?->url ?? asset('assets/images/gallery/gallery-turbine.webp');
    }

    public function getPdfUrlAttribute(): ?string
    {
        return $this->brochure?->url ?? ($this->technical_specifications['pdf_url'] ?? null);
    }
}