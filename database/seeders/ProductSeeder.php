<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'title' => [
                    'en' => 'MAN NR24/R Marine Turbocharger Rotor Assembly',
                    'bn' => 'ম্যান NR24/R মেরিন টার্বোচার্জার রটার অ্যাসেম্বলি',
                ],
                'slug' => 'man-nr24r-rotor-assembly',
                'part_number' => 'MAN-NR24-RTR-901',
                'technical_specifications' => [
                    'category' => 'Rotor Assemblies',
                    'brand' => 'MAN Energy Solutions',
                    'compatible_models' => 'MAN NR15/R, NR20/R, NR24/R, NR26/R Marine Diesel Engines',
                    'condition' => 'Genuine New OEM',
                    'stock_status' => 'In Stock (Central Port Warehouse)',
                    'lead_time' => 'Immediate Port Dispatch (24h)',
                    'warranty' => '12 Months International Marine Class Warranty',
                    'summary' => 'Factory-assembled and dynamic balanced rotor shaft unit fitted with Inconel 713C turbine wheel and forged aluminium compressor wheel.',
                    'description' => 'The MAN NR24/R rotor assembly is engineered for heavy marine propulsion and auxiliary generator applications operating on Heavy Fuel Oil (HFO) and Marine Gas Oil (MGO). Precision balanced down to ISO 1940-1 Grade G1.0 tolerance on Schenck balancing benches, ensuring vibration-free performance up to 48,000 RPM nameplate velocity.',
                    'specs' => [
                        ['key' => 'Max Permissible Speed', 'value' => '48,500 RPM'],
                        ['key' => 'Balancing Quality Grade', 'value' => 'ISO 1940-1 Grade G1.0 (<0.4 mm/s)'],
                        ['key' => 'Turbine Wheel Metallurgy', 'value' => 'Inconel 713C High-Temp Nickel Superalloy'],
                        ['key' => 'Compressor Impeller', 'value' => 'Forged High-Strength Al-Cu-Mg Alloy'],
                        ['key' => 'Shaft Runout Tolerance', 'value' => '< 0.008 mm TIR'],
                        ['key' => 'Class Approvals', 'value' => 'DNV, Lloyd\'s Register, ABS, Bureau Veritas'],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'ABB TPL 77-B Core Cartridge (CHRA) Complete Module',
                    'bn' => 'এবিবি TPL 77-B কোর কার্ট্রিজ (CHRA) সম্পূর্ণ মডিউল',
                ],
                'slug' => 'abb-tpl77-b-chra-cartridge',
                'part_number' => 'ABB-TPL77-CRT-440',
                'technical_specifications' => [
                    'category' => 'Cartridges (CHRA)',
                    'brand' => 'ABB / Accelleron',
                    'compatible_models' => 'ABB TPL 73-B, TPL 77-B, TPL 80-B Two-Stroke Marine Diesel Engines',
                    'condition' => 'Pre-Assembled OEM Exchange Core',
                    'stock_status' => 'In Stock (Ready for Offshore Flying Squad)',
                    'lead_time' => '12-24 Hours Chittagong & Outer Anchorage',
                    'warranty' => '12 Months Full Exchange Warranty',
                    'summary' => 'Pre-balanced, drop-in replacement cartridge module equipped with hydrodynamic journal bearings, thrust collar, and labyrinth sealing.',
                    'description' => 'Designed for 2-stroke low-speed crosshead propulsion engines, the ABB TPL 77-B cartridge allows complete replacement of the core rotating group without disturbing gas exhaust ducting or cooling water piping. Minimizes vessel turnaround times during port demurrage windows.',
                    'specs' => [
                        ['key' => 'Operating Velocity', 'value' => '22,000 RPM Nominal'],
                        ['key' => 'Gas Inlet Temp Limit', 'value' => 'Up to 650°C Continuous'],
                        ['key' => 'Bearing Type', 'value' => 'Hydrodynamic Floating Sleeve Bearings'],
                        ['key' => 'Oil Lubrication Feed', 'value' => 'Engine Main Lube Circuit (1.8 - 2.5 bar)'],
                        ['key' => 'Weight', 'value' => '1,420 kg (Fully Rigged)'],
                        ['key' => 'Balancing Verification', 'value' => 'High-Speed Core Balanced with Certification'],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'Mitsubishi MET 33SC Heat-Treated Nozzle Ring & Shroud Kit',
                    'bn' => 'মিতসুবিশি MET 33SC নজল রিং এবং শ্রাউড কিট',
                ],
                'slug' => 'mitsubishi-met-33sc-nozzle-ring',
                'part_number' => 'MET-33SC-NOZ-112',
                'technical_specifications' => [
                    'category' => 'Nozzle Rings & Shrouds',
                    'brand' => 'Mitsubishi Heavy Industries (MHI)',
                    'compatible_models' => 'Mitsubishi MET 33SC, MET 33SD, MET 42SC Axial Turbochargers',
                    'condition' => 'Genuine New OEM',
                    'stock_status' => 'In Stock (Warehouse Bin B-14)',
                    'lead_time' => 'Immediate Same-Day Dispatch',
                    'warranty' => '12 Months Marine Service Warranty',
                    'summary' => 'High-velocity guide vane assembly manufactured from creep-resistant stainless alloy 310S to optimize gas expansion thermodynamics.',
                    'description' => 'Precision cast nozzle ring with aerodynamic throat geometry matched to vessel engine load profiles. Resists high-temperature sulfidation and vanadium attack from heavy marine fuel combustion.',
                    'specs' => [
                        ['key' => 'Material Specification', 'value' => 'Austenitic Stainless Steel DIN 1.4845 (AISI 310S)'],
                        ['key' => 'Thermal Shock Limit', 'value' => '720°C Peak Exhaust Gas Pulse'],
                        ['key' => 'Throat Area Tolerance', 'value' => '± 1.2% Calibrated Gas Velocity Profile'],
                        ['key' => 'NDT Inspection', 'value' => '100% Fluorescent Penetrant Inspected (FPI)'],
                        ['key' => 'Compatibility', 'value' => 'MHI MET Series Non-Water-Cooled Casings'],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'MAN TCA 66 Ceramic Hybrid Journal & Thrust Bearing Kit',
                    'bn' => 'ম্যান TCA 66 সিরামিক হাইব্রিড জার্নাল ও থ্রাস্ট বিয়ারিং কিট',
                ],
                'slug' => 'man-tca66-bearing-kit',
                'part_number' => 'MAN-TCA66-BRG-208',
                'technical_specifications' => [
                    'category' => 'Bearings & Seals',
                    'brand' => 'MAN Energy Solutions',
                    'compatible_models' => 'MAN TCA 55, TCA 66, TCA 77 Axial Turbochargers',
                    'condition' => 'Precision OEM Kit',
                    'stock_status' => 'In Stock (Sealed Moisture-Proof Packaging)',
                    'lead_time' => 'Immediate Port Dispatch (24h)',
                    'warranty' => '8,000 Running Hours / 12 Months Marine Guarantee',
                    'summary' => 'Heavy-duty sintered bronze and ceramic-coated bearing package with labyrinth seals, oil slingers, and O-ring sealing elements.',
                    'description' => 'Comprehensive overhaul bearing kit providing high anti-friction resistance and dampening for high-output MAN TCA turbochargers. Formulated to withstand boundary lubrication during cold startup and high emergency exhaust gas surges.',
                    'specs' => [
                        ['key' => 'Composition', 'value' => 'CuPb22Sn4 Sintered Bronze with Ceramic Coating'],
                        ['key' => 'Thrust Capacity', 'value' => 'Dual-Direction Axial Load Dampening'],
                        ['key' => 'Seal Type', 'value' => 'Multi-Labyrinth Pressurized Air Sealing'],
                        ['key' => 'Oil Filtration Req.', 'value' => '15 Micron Lube Oil Conditioning'],
                        ['key' => 'Kit Inclusions', 'value' => 'Thrust Bearing, 2x Journal Sleeves, Labyrinths, Lock Plates'],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'Napier NA 297 High-Pressure Gas Turbine Rotor Blades Set',
                    'bn' => 'নেপিয়ার NA 297 হাই-প্রেসার গ্যাস টার্বাইন ব্লেড সেট',
                ],
                'slug' => 'napier-na297-turbine-blades',
                'part_number' => 'NAP-NA297-BLD-550',
                'technical_specifications' => [
                    'category' => 'Turbine Blading',
                    'brand' => 'Napier Turbochargers',
                    'compatible_models' => 'Napier NA 295, NA 297, NA 357 Medium-Speed Marine & Power Turbines',
                    'condition' => 'Class Certified Precision Re-machined',
                    'stock_status' => 'Available on Demand (Warehouse Bin C-02)',
                    'lead_time' => '48 Hours Delivery to Anchorage',
                    'warranty' => '12 Months Class Certified Guarantee',
                    'summary' => 'Aerodynamically contoured vacuum-cast turbine blades with fir-tree root geometry and damping wire holes.',
                    'description' => 'Manufactured from vacuum-melted Inconel 738LC for exceptional stress-rupture strength at elevated temperatures. Micro-broached fir-tree root profiles guarantee uniform rotor disc centrifugal stress distribution.',
                    'specs' => [
                        ['key' => 'Blade Superalloy', 'value' => 'Vacuum Cast Inconel 738LC Superalloy'],
                        ['key' => 'Root Fastening', 'value' => 'Precision 3-Lobe Fir-Tree Geometry'],
                        ['key' => 'Blade Count per Set', 'value' => 'Matched & Moment-Weighed Complete Disc Set (48 Pcs)'],
                        ['key' => 'Max Exhaust Temp', 'value' => '680°C Continuous Duty'],
                        ['key' => 'Moment-Weighing', 'value' => 'Pre-Sequenced for Zero Rotor Imbalance Deviation'],
                    ],
                ],
                'is_active' => true,
            ],
            [
                'title' => [
                    'en' => 'KBB HPR 4000 Billet Titanium 5-Axis CNC Compressor Impeller',
                    'bn' => 'কেবিবি HPR 4000 বিলেট টাইটানিয়াম ৫-অ্যাক্সিস কম্প্রেসার ইম্পেলার',
                ],
                'slug' => 'kbb-hpr4000-titanium-compressor-impeller',
                'part_number' => 'KBB-HPR4-CMP-303',
                'technical_specifications' => [
                    'category' => 'Compressor Impellers',
                    'brand' => 'KBB Turbochargers',
                    'compatible_models' => 'KBB HPR 3000, HPR 4000, HPR 5000 High-Pressure Marine Generators',
                    'condition' => 'Genuine New OEM / Solid Billet Milled',
                    'stock_status' => 'In Stock (Central Warehouse Bin A-08)',
                    'lead_time' => 'Immediate Port Dispatch (24h)',
                    'warranty' => '12 Months Full Replacement Warranty',
                    'summary' => 'Solid aerospace-grade titanium alloy compressor wheel delivering ultra-high pressure ratios up to 5.0:1 without fatigue creep.',
                    'description' => 'Milled from a single solid billet of aerospace titanium Ti-6Al-4V using 5-axis CNC machining centers. Eliminates the casting porosities of traditional aluminium wheels, providing immense resistance against marine salt air pitting and supersonic blade tip flutter.',
                    'specs' => [
                        ['key' => 'Raw Material', 'value' => 'Billet Titanium Ti-6Al-4V (Grade 5 Aerospace)'],
                        ['key' => 'Pressure Ratio Capability', 'value' => 'Up to 5.2 : 1 Continuous Boost'],
                        ['key' => 'Blade Profile', 'value' => 'Splitter Blade Aerodynamic Design (14 Full + 14 Splitter)'],
                        ['key' => 'Corrosion Immunity', 'value' => '100% Salt Fog & Marine Atmosphere Pitting Resistant'],
                        ['key' => 'Overspeed Test Limit', 'value' => 'Spin-Tested to 120% Maximum Continuous Rating'],
                    ],
                ],
                'is_active' => true,
            ],
        ];

        foreach ($products as $pData) {
            Product::updateOrCreate(
                ['slug' => $pData['slug']],
                $pData
            );
        }
    }
}
