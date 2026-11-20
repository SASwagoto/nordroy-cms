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
        Schema::create('rfq_form_fields', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->string('type')->default('text'); // text, email, tel, number, textarea, select, radio, checkbox, date
            $table->string('placeholder')->nullable();
            $table->unsignedTinyInteger('width')->default(12); // 12 = full (100%), 6 = half (50%), 4 = 1/3 (33%), 3 = 1/4 (25%)
            $table->json('options')->nullable(); // Array of ['label' => '...', 'value' => '...']
            $table->boolean('is_required')->default(false);
            $table->string('default_value')->nullable();
            $table->string('help_text')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rfq_form_fields');
    }
};
