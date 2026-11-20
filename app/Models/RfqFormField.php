<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqFormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'label',
        'type',
        'placeholder',
        'width',
        'options',
        'is_required',
        'default_value',
        'help_text',
        'order',
        'is_active',
    ];

    protected $casts = [
        'options'     => 'array',
        'is_required' => 'boolean',
        'is_active'   => 'boolean',
        'width'       => 'integer',
        'order'       => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order', 'asc');
    }

    /**
     * Standard built-in default fields for Maritime Engineering RFQ
     */
    public static function getDefaultFields(): array
    {
        return [
            [
                'name'          => 'full_name',
                'label'         => 'Contact Person / Superintendent',
                'type'          => 'text',
                'placeholder'   => 'Capt. / Engr. Full Name',
                'width'         => 6,
                'options'       => null,
                'is_required'   => true,
                'default_value' => null,
                'help_text'     => 'Primary engineering or vessel superintendent contact.',
                'order'         => 1,
                'is_active'     => true,
            ],
            [
                'name'          => 'company',
                'label'         => 'Corporate / Shipping Line Company',
                'type'          => 'text',
                'placeholder'   => 'e.g. Pacific Bulk Logistics Ltd.',
                'width'         => 6,
                'options'       => null,
                'is_required'   => false,
                'default_value' => null,
                'help_text'     => 'Registered shipping agency, owner, or industrial plant.',
                'order'         => 2,
                'is_active'     => true,
            ],
            [
                'name'          => 'email',
                'label'         => 'Technical Email',
                'type'          => 'email',
                'placeholder'   => 'technical.ops@shipping-company.com',
                'width'         => 6,
                'options'       => null,
                'is_required'   => true,
                'default_value' => null,
                'help_text'     => 'Official technical correspondence email.',
                'order'         => 3,
                'is_active'     => true,
            ],
            [
                'name'          => 'phone',
                'label'         => 'Phone / WhatsApp (Direct Dispatch)',
                'type'          => 'tel',
                'placeholder'   => '+880 1800-000000 / International format',
                'width'         => 6,
                'options'       => null,
                'is_required'   => true,
                'default_value' => null,
                'help_text'     => '24/7 direct number for rapid port dispatch.',
                'order'         => 4,
                'is_active'     => true,
            ],
            [
                'name'          => 'vessel_plant_name',
                'label'         => 'Vessel / Power Plant Name',
                'type'          => 'text',
                'placeholder'   => 'e.g. M/V Nordroy Carrier or Unit 3 Turbine',
                'width'         => 6,
                'options'       => null,
                'is_required'   => true,
                'default_value' => null,
                'help_text'     => 'Ship name or manufacturing plant location.',
                'order'         => 5,
                'is_active'     => true,
            ],
            [
                'name'          => 'turbocharger_model',
                'label'         => 'Turbocharger Model & Serial',
                'type'          => 'text',
                'placeholder'   => 'e.g. ABB TPL-77, MAN TCR22, Napier NA297',
                'width'         => 6,
                'options'       => null,
                'is_required'   => true,
                'default_value' => null,
                'help_text'     => 'OEM model specification stamped on casing nameplate.',
                'order'         => 6,
                'is_active'     => true,
            ],
            [
                'name'          => 'port_location',
                'label'         => 'Port / Facility Location',
                'type'          => 'text',
                'placeholder'   => 'Chattogram / Mongla / Anchorage',
                'width'         => 4,
                'options'       => null,
                'is_required'   => true,
                'default_value' => 'Chattogram Port',
                'help_text'     => 'Berth location or coordinates.',
                'order'         => 7,
                'is_active'     => true,
            ],
            [
                'name'          => 'service_required',
                'label'         => 'Required Service',
                'type'          => 'select',
                'placeholder'   => 'Select service category',
                'width'         => 4,
                'options'       => [
                    ['label' => 'Complete Overhaul & Dynamic Balancing', 'value' => 'Complete Overhaul & Dynamic Balancing'],
                    ['label' => 'CHRA Cartridge Exchange', 'value' => 'CHRA Cartridge Exchange'],
                    ['label' => 'Emergency Flying Squad to Vessel', 'value' => 'Emergency Flying Squad to Vessel'],
                    ['label' => 'Spare Parts Purchase', 'value' => 'Spare Parts Purchase'],
                    ['label' => 'NDT Metallurgical Inspection', 'value' => 'NDT Metallurgical Inspection'],
                    ['label' => 'Retrofit & Performance Upgrade', 'value' => 'Retrofit & Performance Upgrade'],
                ],
                'is_required'   => true,
                'default_value' => 'Complete Overhaul & Dynamic Balancing',
                'help_text'     => 'Core marine engineering service scope.',
                'order'         => 8,
                'is_active'     => true,
            ],
            [
                'name'          => 'urgency',
                'label'         => 'Urgency Level',
                'type'          => 'select',
                'placeholder'   => 'Select priority level',
                'width'         => 4,
                'options'       => [
                    ['label' => 'Standard Scheduled Maintenance', 'value' => 'Standard Scheduled Maintenance'],
                    ['label' => 'Urgent Port Call (Within 48h)', 'value' => 'Urgent Port Call (Within 48h)'],
                    ['label' => 'Emergency Vessel Blackout / AOG', 'value' => 'Emergency Vessel Blackout / AOG'],
                ],
                'is_required'   => true,
                'default_value' => 'Standard Scheduled Maintenance',
                'help_text'     => 'Response SLA depends on urgency level.',
                'order'         => 9,
                'is_active'     => true,
            ],
            [
                'name'          => 'message',
                'label'         => 'Technical Symptoms & Observed Issues',
                'type'          => 'textarea',
                'placeholder'   => 'Describe symptoms (e.g. abnormal vibration levels > 10 mm/s RMS, oil leaks at exhaust casing, high exhaust gas temps, surging under load)...',
                'width'         => 12,
                'options'       => null,
                'is_required'   => true,
                'default_value' => null,
                'help_text'     => 'Detailed operational parameters and observed mechanical faults.',
                'order'         => 10,
                'is_active'     => true,
            ],
        ];
    }

    /**
     * Seeds the defaults if table is empty
     */
    public static function seedDefaultsIfEmpty(): void
    {
        if (static::count() === 0) {
            foreach (static::getDefaultFields() as $field) {
                static::create($field);
            }
        }
    }
}
