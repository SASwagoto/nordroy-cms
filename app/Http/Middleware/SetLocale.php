<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale') ?? $request->cookie('locale');

        // Check if database has this active language
        $isValid = false;
        try {
            $isValid = $locale && Language::where('code', $locale)->where('is_active', true)->exists();
        } catch (\Throwable $e) {
            // DB not ready or running migration
        }

        if (! $isValid) {
            try {
                $locale = Language::where('is_default', true)->value('code') ?? config('app.locale', 'en');
            } catch (\Throwable $e) {
                $locale = config('app.locale', 'en');
            }
        }

        App::setLocale($locale);

        $direction = 'ltr';
        $activeLanguage = null;
        try {
            $activeLanguage = Language::where('code', $locale)->first();
            $direction = $activeLanguage?->direction ?? 'ltr';
        } catch (\Throwable $e) {
            // Safe fallback
        }

        View::share('currentLocale', $locale);
        View::share('currentLanguageDirection', $direction);
        View::share('currentLanguage', $activeLanguage);

        return $next($request);
    }
}
