<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobFormField extends Model
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
     * Standard built-in default fields for Maritime Engineering Job Applications
     */
    public static function getDefaultFields(): array
    {
        return [
            [
                'name'          => 'full_name',
                'label'         => 'Full Name',
                'type'          => 'text',
                'placeholder'   => 'e.g. Engr. Tanvir Ahmed',
                'width'         => 6,
                'options'       => null,
                'is_required'   => true,
                'default_value' => null,
                'help_text'     => 'Applicant legal full name.',
                'order'         => 1,
                'is_active'     => true,
            ],
            [
                'name'          => 'email',
                'label'         => 'Email Address',
                'type'          => 'email',
                'placeholder'   => 'tanvir.marine@gmail.com',
                'width'         => 6,
                'options'       => null,
                'is_required'   => true,
                'default_value' => null,
                'help_text'     => 'Direct correspondence and interview communication.',
                'order'         => 2,
                'is_active'     => true,
            ],
            [
                'name'          => 'phone',
                'label'         => 'Phone / WhatsApp',
                'type'          => 'tel',
                'placeholder'   => '+880 1700-000000',
                'width'         => 6,
                'options'       => null,
                'is_required'   => true,
                'default_value' => null,
                'help_text'     => 'Active contact number.',
                'order'         => 3,
                'is_active'     => true,
            ],
            [
                'name'          => 'current_company',
                'label'         => 'Current / Most Recent Company',
                'type'          => 'text',
                'placeholder'   => 'e.g. Western Marine Shipyard or Meghna Group',
                'width'         => 6,
                'options'       => null,
                'is_required'   => false,
                'default_value' => null,
                'help_text'     => 'Current employer or maritime workshop.',
                'order'         => 4,
                'is_active'     => true,
            ],
            [
                'name'          => 'years_experience',
                'label'         => 'Relevant Engineering Experience',
                'type'          => 'select',
                'placeholder'   => 'Select experience level',
                'width'         => 4,
                'options'       => [
                    ['label' => 'Fresh Graduate / Entry Level', 'value' => 'Fresh Graduate / Entry Level'],
                    ['label' => '1 - 3 Years', 'value' => '1 - 3 Years'],
                    ['label' => '3 - 5 Years (Mid-Level)', 'value' => '3 - 5 Years (Mid-Level)'],
                    ['label' => '5 - 8 Years (Senior Specialist)', 'value' => '5 - 8 Years (Senior Specialist)'],
                    ['label' => '8+ Years (Chief / Superintendent)', 'value' => '8+ Years (Chief / Superintendent)'],
                ],
                'is_required'   => true,
                'default_value' => '3 - 5 Years (Mid-Level)',
                'help_text'     => 'Total hands-on mechanical / marine experience.',
                'order'         => 5,
                'is_active'     => true,
            ],
            [
                'name'          => 'expected_salary',
                'label'         => 'Expected Monthly Salary',
                'type'          => 'text',
                'placeholder'   => 'e.g. BDT 80,000 / Negotiable',
                'width'         => 4,
                'options'       => null,
                'is_required'   => false,
                'default_value' => null,
                'help_text'     => 'Gross monthly remuneration in BDT or USD.',
                'order'         => 6,
                'is_active'     => true,
            ],
            [
                'name'          => 'notice_period',
                'label'         => 'Notice Period / Availability',
                'type'          => 'select',
                'placeholder'   => 'Select availability',
                'width'         => 4,
                'options'       => [
                    ['label' => 'Immediate (Within 7 Days)', 'value' => 'Immediate (Within 7 Days)'],
                    ['label' => '15 Days', 'value' => '15 Days'],
                    ['label' => '1 Month', 'value' => '1 Month'],
                    ['label' => '2 Months', 'value' => '2 Months'],
                ],
                'is_required'   => true,
                'default_value' => 'Immediate (Within 7 Days)',
                'help_text'     => 'Earliest joining date if selected.',
                'order'         => 7,
                'is_active'     => true,
            ],
            [
                'name'          => 'portfolio_url',
                'label'         => 'LinkedIn / Technical Profile',
                'type'          => 'text',
                'placeholder'   => 'https://linkedin.com/in/username',
                'width'         => 6,
                'options'       => null,
                'is_required'   => false,
                'default_value' => null,
                'help_text'     => 'Link to LinkedIn, ResearchGate, or online portfolio.',
                'order'         => 8,
                'is_active'     => true,
            ],
            [
                'name'          => 'resume',
                'label'         => 'Curriculum Vitae / Resume (PDF / DOCX)',
                'type'          => 'file',
                'placeholder'   => 'Upload Resume',
                'width'         => 6,
                'options'       => null,
                'is_required'   => true,
                'default_value' => null,
                'help_text'     => 'Attach comprehensive CV (Max 10MB, PDF or Word).',
                'order'         => 9,
                'is_active'     => true,
            ],
            [
                'name'          => 'cover_letter',
                'label'         => 'Summary of Expertise & Technical Scope',
                'type'          => 'textarea',
                'placeholder'   => 'Describe your hands-on competencies (e.g. Schenck balancing machines, ABB/MAN/Napier turbochargers, NDT testing, offshore flying squads)...',
                'width'         => 12,
                'options'       => null,
                'is_required'   => false,
                'default_value' => null,
                'help_text'     => 'Brief technical overview highlighting your relevant experience.',
                'order'         => 10,
                'is_active'     => true,
            ],
        ];
    }

    public static function seedDefaultsIfEmpty(): void
    {
        if (static::count() === 0) {
            foreach (static::getDefaultFields() as $field) {
                static::create($field);
            }
        }
    }
}
