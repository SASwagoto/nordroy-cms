<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Job Postings / Vacancies
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('department')->default('Marine Engineering');
            $table->string('employment_type')->default('Full-Time'); // Full-Time, Contract, Offshore Rotation, Internship, Part-Time
            $table->string('location')->default('Chattogram Port Workshop');
            $table->string('experience_level')->default('3-5 Years');
            $table->string('salary_range')->nullable();
            $table->longText('description');
            $table->longText('requirements')->nullable();
            $table->longText('benefits')->nullable();
            $table->date('deadline')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // 2. Dynamic Career Form Fields (Form Builder)
        Schema::create('job_form_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->string('type')->default('text'); // text, email, tel, number, textarea, select, file, date, radio, checkbox
            $table->string('placeholder')->nullable();
            $table->unsignedTinyInteger('width')->default(12); // 12 = full, 6 = half, 4 = 1/3, 3 = 1/4
            $table->json('options')->nullable(); // Array of ['label' => '...', 'value' => '...']
            $table->boolean('is_required')->default(false);
            $table->string('default_value')->nullable();
            $table->string('help_text')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Received Job Applications
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_posting_id')->nullable()->constrained('job_postings')->nullOnDelete();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('resume_path')->nullable();
            $table->text('cover_letter')->nullable();
            $table->json('payload')->nullable(); // Stores all dynamic fields
            $table->string('status')->default('new'); // new, reviewing, shortlisted, interview, rejected, hired
            $table->text('admin_notes')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
        Schema::dropIfExists('job_form_fields');
        Schema::dropIfExists('job_postings');
    }
};
