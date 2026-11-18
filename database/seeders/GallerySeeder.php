<?php

namespace Database\Seeders;

use App\Models\GalleryAlbum;
use App\Models\MediaAsset;
use App\Models\PhotoGallery;
use App\Models\Service;
use App\Models\VideoGallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $assets = MediaAsset::all();
        $firstAsset = $assets->first();

        // 1. Create Albums
        $album1 = GalleryAlbum::firstOrCreate(
            ['slug' => 'dynamic-balancing'],
            [
                'name' => [
                    'en' => 'High-Speed Dynamic Balancing',
                    'bn' => 'হাই-স্পিড ডাইনামিক ব্যালেন্সিং',
                ],
                'description' => [
                    'en' => 'Schenck dynamic balancing benches operating to ISO 1940 Grade G1.0 tolerance down to 0.42 mm/s vibration.',
                    'bn' => 'শেঙ্ক ব্যালেন্সিং বেঞ্চে আইএসও ১৯৪০ গ্রেড জি১.০ স্ট্যান্ডার্ডে উচ্চমানের রোটর ব্যালেন্সিং।',
                ],
                'cover_image_id' => $firstAsset?->id,
                'order' => 1,
                'is_active' => true,
            ]
        );

        $album2 = GalleryAlbum::firstOrCreate(
            ['slug' => 'turbocharger-overhaul'],
            [
                'name' => [
                    'en' => 'Marine Turbocharger Overhaul',
                    'bn' => 'মেরিন টার্বোচার্জার ওভারহোল',
                ],
                'description' => [
                    'en' => 'Complete cartridge dismantling, ultrasonic decarbonization, and precision reassembly with OEM spare parts.',
                    'bn' => 'সম্পূর্ণ কার্ত্রিজ ডিসম্যান্টলিং, আল্ট্রাসনিক ডিকার্বনাইজেশন এবং জেনুইন পার্টস প্রতিস্থাপন।',
                ],
                'cover_image_id' => $assets->skip(1)->first()?->id ?? $firstAsset?->id,
                'order' => 2,
                'is_active' => true,
            ]
        );

        $album3 = GalleryAlbum::firstOrCreate(
            ['slug' => 'port-attendance'],
            [
                'name' => [
                    'en' => 'Emergency Port Flying Squad',
                    'bn' => 'ইমার্জেন্সি পোর্ট ফ্লাইং স্কোয়াড',
                ],
                'description' => [
                    'en' => '24/7 emergency attendance aboard container ships, oil tankers, and bulk carriers in Chittagong & Mongla.',
                    'bn' => 'চট্টগ্রাম ও মোংলা বন্দরে কন্টেইনার জাহাজ এবং ট্যাংকারে ২৪/৭ অনবোর্ড সেবা।',
                ],
                'cover_image_id' => $assets->skip(2)->first()?->id ?? $firstAsset?->id,
                'order' => 3,
                'is_active' => true,
            ]
        );

        // 2. Populate Photos if none exist
        if (PhotoGallery::count() === 0 && $assets->count() > 0) {
            $albumsList = [$album1->id, $album2->id, $album3->id];
            $captions = [
                'Dynamic balancing bench calibration at 18,500 RPM',
                'Ultrasonic chemical cleaning tank decarbonization',
                'Turbine blade fluorescent penetrant inspection (NDT)',
                'Ceramic hybrid journal bearings and labyrinth seals fitting',
                'Emergency rigging aboard 85,000 DWT container vessel',
                'Full sea-trial turbocharger boost pressure verification',
            ];

            foreach ($assets as $idx => $asset) {
                PhotoGallery::create([
                    'album_id' => $albumsList[$idx % count($albumsList)],
                    'media_id' => $asset->id,
                    'title' => [
                        'en' => $asset->getTranslation('title', 'en') ?: 'Overhaul Operation #' . ($idx + 1),
                        'bn' => 'ওভারহোল অপারেশন #' . ($idx + 1),
                    ],
                    'caption' => [
                        'en' => $captions[$idx % count($captions)],
                        'bn' => 'আন্তর্জাতিক মান নিশ্চিতকরণ এবং পরিদর্শন প্রক্রিয়া।',
                    ],
                    'order' => $idx + 1,
                    'is_active' => true,
                ]);
            }
        }

        // 3. Populate Videos if none exist
        if (VideoGallery::count() === 0) {
            VideoGallery::create([
                'album_id' => $album1->id,
                'title' => [
                    'en' => 'Marine Vessel Turbocharger Overhaul & High-Speed Dynamic Balancing',
                    'bn' => 'মেরিন ভেসেল টার্বোচার্জার ওভারহোল এবং হাই-স্পিড ডাইনামিক ব্যালেন্সিং',
                ],
                'youtube_url' => 'https://www.youtube.com/watch?v=9No-FiEInLA',
                'youtube_id' => '9No-FiEInLA',
                'thumbnail_id' => null,
                'description' => [
                    'en' => '<p>Live footage showing high-speed dual plane dynamic balancing of a MAN NR/S 34 series rotor on our calibrated Schenck balance bench. Residual vibration reduced to below 0.42 mm/s.</p>',
                    'bn' => '<p>শেঙ্ক ব্যালেন্সিং বেঞ্চে এমএএন এনআর/এস ৩৪ সিরিজের রোটরের লাইভ ডাইনামিক ব্যালেন্সিং ফুটেজ।</p>',
                ],
                'order' => 1,
                'is_active' => true,
            ]);

            VideoGallery::create([
                'album_id' => $album2->id,
                'title' => [
                    'en' => '2.5MW Industrial Power Plant Turbocharger Refit & Overhaul',
                    'bn' => '২.৫ মেগাওয়াট ইন্ডাস্ট্রিয়াল পাওয়ার প্ল্যান্ট টার্বোচার্জার রিফিট',
                ],
                'youtube_url' => 'https://www.youtube.com/watch?v=kJQP7kiw5Fk',
                'youtube_id' => 'kJQP7kiw5Fk',
                'thumbnail_id' => null,
                'description' => [
                    'en' => '<p>Continuous heavy-duty turbine overhaul and compressor cartridge overhaul for heavy manufacturing plant in Gazipur industrial zone.</p>',
                    'bn' => '<p>শিল্প কারখানায় টার্বোচার্জার কার্ত্রিজ ওভারহোল ও পারফরম্যান্স টিউনিং।</p>',
                ],
                'order' => 2,
                'is_active' => true,
            ]);

            VideoGallery::create([
                'album_id' => $album3->id,
                'title' => [
                    'en' => '24/7 Port Emergency Squad - Ship Engine Room Attendance',
                    'bn' => '২৪/৭ পোর্ট ইমার্জেন্সি স্কোয়াড - ইঞ্জিন রুম অ্যাটেন্ডেন্স',
                ],
                'youtube_url' => 'https://www.youtube.com/watch?v=9No-FiEInLA',
                'youtube_id' => '9No-FiEInLA',
                'thumbnail_id' => null,
                'description' => [
                    'en' => '<p>Emergency extraction of a failed turbocharger rotor cartridge inside ship engine room at Chittagong Port Outer Anchorage within strict 36-hour demurrage window.</p>',
                    'bn' => '<p>চট্টগ্রাম বন্দর আউটার অ্যাঙ্করেজে জাহাজের ইঞ্জিন রুমে ইমার্জেন্সি টার্বোচার্জার মেরামত।</p>',
                ],
                'order' => 3,
                'is_active' => true,
            ]);
        }

        // 4. Update existing services with sample video_url if empty
        Service::whereNull('video_url')->orWhere('video_url', '')->take(2)->update([
            'video_url' => 'https://www.youtube.com/watch?v=9No-FiEInLA',
        ]);
    }
}
