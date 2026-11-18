<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        Language::firstOrCreate(
            ['code' => 'en'],
            [
                'name'        => 'English',
                'native_name' => 'English',
                'direction'   => 'ltr',
                'flag_icon'   => '🇬🇧',
                'is_default'  => true,
                'is_active'   => true,
                'order'       => 1,
            ]
        );

        Language::firstOrCreate(
            ['code' => 'bn'],
            [
                'name'        => 'Bengali',
                'native_name' => 'বাংলা',
                'direction'   => 'ltr',
                'flag_icon'   => '🇧🇩',
                'is_default'  => false,
                'is_active'   => true,
                'order'       => 2,
            ]
        );
    }
}
