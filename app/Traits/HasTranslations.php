<?php

namespace App\Traits;

trait HasTranslations
{
    /**
     * Automatically convert translatable array attributes to string
     * when accessed as a model property (e.g. $model->title).
     */
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);

        if (is_array($value) && (isset($value['en']) || isset($value['bn']))) {
            $locale = app()->getLocale();
            return $value[$locale]
                ?? $value[config('app.fallback_locale', 'en')]
                ?? (reset($value) ?: '');
        }

        return $value;
    }

    /**
     * Get translated attribute value.
     */
    public function getTranslation(string $attribute, ?string $locale = null): mixed
    {
        $locale = $locale ?? app()->getLocale();
        $raw = $this->attributes[$attribute] ?? null;

        if (is_null($raw)) {
            return null;
        }

        $translations = is_array($raw) ? $raw : json_decode($raw, true);

        if (! is_array($translations)) {
            return $raw;
        }

        return $translations[$locale]
            ?? $translations[config('app.fallback_locale', 'en')]
            ?? array_values($translations)[0]
            ?? null;
    }

    /**
     * Set translated attribute value.
     */
    public function setTranslation(string $attribute, string $locale, mixed $value): self
    {
        $raw = $this->attributes[$attribute] ?? null;
        $translations = is_array($raw) ? $raw : (json_decode($raw, true) ?? []);

        $translations[$locale] = $value;
        $this->attributes[$attribute] = json_encode($translations, JSON_UNESCAPED_UNICODE);

        return $this;
    }
}
