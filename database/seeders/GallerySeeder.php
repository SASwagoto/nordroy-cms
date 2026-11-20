<?php

namespace Database\Seeders;

use App\Models\GalleryAlbum;
use App\Models\MediaAsset;
use App\Models\PhotoGallery;
use App\Models\Service;
use App\Models\VideoGallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Albums
        $albumBalancing = GalleryAlbum::updateOrCreate(
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
                'type' => 'all',
                'order' => 1,
                'is_active' => true,
            ]
        );

        $albumOverhaul = GalleryAlbum::updateOrCreate(
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
                'type' => 'all',
                'order' => 2,
                'is_active' => true,
            ]
        );

        $albumPort = GalleryAlbum::updateOrCreate(
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
                'type' => 'all',
                'order' => 3,
                'is_active' => true,
            ]
        );

        // 2. Register genuine gallery media assets
        $galleryImages = [
            [
                'file_name' => 'gallery-balancing.webp',
                'title_en'  => 'Dynamic Rotor Balancing on Schenck Bench',
                'title_bn'  => 'শেঙ্ক বেঞ্চে ডাইনামিক রোটর ব্যালেন্সিং',
                'caption_en'=> 'Dual-plane high-speed dynamic balancing up to 25,000 RPM at G1.0 tolerance.',
                'caption_bn'=> '২৫,০০০ আরপিএম পর্যন্ত উচ্চগতিতে ডাইনামিক ব্যালেন্সিং।',
                'album_id'  => $albumBalancing->id,
            ],
            [
                'file_name' => 'gallery-turbine.webp',
                'title_en'  => 'Inconel 713C Turbine Rotor Inspection',
                'title_bn'  => 'ইনকোনেল 713C টার্বাইন রোটর পরিদর্শন',
                'caption_en'=> 'Precision tolerance and dimensional runout check with dial indicator.',
                'caption_bn'=> 'ডায়াল ইন্ডিকেটর দিয়ে রানআউট এবং সহনশীলতা পরীক্ষা।',
                'album_id'  => $albumOverhaul->id,
            ],
            [
                'file_name' => 'gallery-technician.jpg',
                'title_en'  => 'Certified Marine Specialist Calibration',
                'title_bn'  => 'সার্টিফাইড মেরিন বিশেষজ্ঞের ক্যালিব্রেশন',
                'caption_en'=> 'Ultrasonic thickness testing and non-destructive crack detection.',
                'caption_bn'=> 'আল্ট্রাসনিক থিকনেস টেস্ট এবং ক্র্যাক ডিটেকশন পরীক্ষা।',
                'album_id'  => $albumOverhaul->id,
            ],
            [
                'file_name' => 'gallery-vessel.jpg',
                'title_en'  => '85,000 DWT Container Ship Emergency Attendance',
                'title_bn'  => '৮৫,০০০ DWT কন্টেইনার জাহাজে জরুরি সেবা',
                'caption_en'=> 'Port call emergency turbocharger cartridge replacement within 36 hours.',
                'caption_bn'=> '৩৬ ঘণ্টার মধ্যে জাহাজে কার্ত্রিজ প্রতিস্থাপন সম্পন্ন।',
                'album_id'  => $albumPort->id,
            ],
            [
                'file_name' => 'gallery-welding.webp',
                'title_en'  => 'High-Purity Argon Micro-TIG Casing Welding',
                'title_bn'  => 'হাই-পিউরিটি আর্গন মাইক্রো-টিআইজি কেসিং ওয়েল্ডিং',
                'caption_en'=> 'Nickel-alloy repair of thermal fatigue erosion on gas inlet casing.',
                'caption_bn'=> 'গ্যাস ইনলেট কেসিংয়ে ক্ষয়প্রাপ্ত অংশ মেরামত।',
                'album_id'  => $albumOverhaul->id,
            ],
            [
                'file_name' => 'gallery-plant.webp',
                'title_en'  => '2.5MW Industrial Captive Power Generator Turbocharger',
                'title_bn'  => '২.৫ মেগাওয়াট পাওয়ার প্ল্যান্ট টার্বোচার্জার',
                'caption_en'=> 'Full heavy overhaul of captive dual-fuel engine turbocharger module.',
                'caption_bn'=> 'ইন্ডাস্ট্রিয়াল ডুয়েল ফুয়েল ইঞ্জিন টার্বোচার্জার সম্পূর্ণ ওভারহোল।',
                'album_id'  => $albumBalancing->id,
            ],
            [
                'file_name' => 'gallery-generator.webp',
                'title_en'  => 'Auxiliary Generator Turbocharger Reassembly',
                'title_bn'  => 'অক্সিলারি জেনারেটর টার্বোচার্জার সংযোজন',
                'caption_en'=> 'Ceramic hybrid journal bearings and labyrinth seals installation.',
                'caption_bn'=> 'সিরামিক হাইব্রিড বিয়ারিং ও সীল ইনস্টলেশন।',
                'album_id'  => $albumOverhaul->id,
            ],
            [
                'file_name' => 'gallery-substation.webp',
                'title_en'  => 'Industrial Energy Grid Synchronization Test',
                'title_bn'  => 'ইন্ডাস্ট্রিয়াল গ্রিড সিঙ্ক্রোনাইজেশন পরীক্ষা',
                'caption_en'=> 'Sea-trial load testing and vibration spectrum logging post overhaul.',
                'caption_bn'=> 'লোড টেস্টিং এবং ভাইব্রেশন স্পেকট্রাম পর্যবেক্ষণ।',
                'album_id'  => $albumPort->id,
            ],
        ];

        // Wipe old false photo gallery entries (that were linked to site logos/icons)
        PhotoGallery::truncate();

        $order = 1;
        $firstMedia = null;
        foreach ($galleryImages as $item) {
            $srcPath = public_path('assets/images/gallery/' . $item['file_name']);
            $size = File::exists($srcPath) ? File::size($srcPath) : 150000;
            $ext = pathinfo($item['file_name'], PATHINFO_EXTENSION);
            $mime = in_array($ext, ['webp', 'jpg', 'jpeg', 'png']) ? "image/{$ext}" : 'image/jpeg';
            $hash = File::exists($srcPath) ? hash_file('sha256', $srcPath) : 'gallery-hash-' . $order;

            $asset = MediaAsset::firstOrCreate(
                ['file_hash' => $hash],
                [
                    'disk'      => 'public',
                    'file_path' => 'gallery/' . $item['file_name'],
                    'file_name' => $item['file_name'],
                    'mime_type' => $mime,
                    'file_size' => $size,
                    'width'     => 1200,
                    'height'    => 800,
                    'folder'    => 'gallery',
                    'title'     => ['en' => $item['title_en'], 'bn' => $item['title_bn']],
                    'alt_text'  => ['en' => $item['title_en'], 'bn' => $item['title_bn']],
                ]
            );

            if (!$firstMedia) {
                $firstMedia = $asset;
            }

            PhotoGallery::create([
                'album_id'  => $item['album_id'],
                'media_id'  => $asset->id,
                'title'     => [
                    'en' => $item['title_en'],
                    'bn' => $item['title_bn'],
                ],
                'caption'   => [
                    'en' => $item['caption_en'],
                    'bn' => $item['caption_bn'],
                ],
                'order'     => $order++,
                'is_active' => true,
            ]);
        }

        // Set cover images on albums
        if ($firstMedia) {
            $albumBalancing->update(['cover_image_id' => $firstMedia->id]);
            $albumOverhaul->update(['cover_image_id' => $firstMedia->id]);
            $albumPort->update(['cover_image_id' => $firstMedia->id]);
        }

        // 3. Populate Videos if none exist
        if (VideoGallery::count() === 0) {
            VideoGallery::create([
                'album_id' => $albumBalancing->id,
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
                'album_id' => $albumOverhaul->id,
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
                'album_id' => $albumPort->id,
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
    }
}
