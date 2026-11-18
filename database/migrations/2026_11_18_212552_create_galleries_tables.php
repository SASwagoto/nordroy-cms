<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_albums', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('slug')->unique();
            $table->json('description')->nullable();
            $table->foreignId('cover_image_id')->nullable()->constrained('media_assets')->nullOnDelete();
            $table->string('type', 20)->default('all'); // all, photo, video
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'order']);
        });

        Schema::create('photo_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->nullable()->constrained('gallery_albums')->nullOnDelete();
            $table->foreignId('media_id')->constrained('media_assets')->cascadeOnDelete();
            $table->json('title')->nullable();
            $table->json('caption')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'order']);
        });

        Schema::create('video_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->nullable()->constrained('gallery_albums')->nullOnDelete();
            $table->json('title');
            $table->string('youtube_url', 500);
            $table->string('youtube_id', 50)->nullable();
            $table->foreignId('thumbnail_id')->nullable()->constrained('media_assets')->nullOnDelete();
            $table->json('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('video_galleries');
        Schema::dropIfExists('photo_galleries');
        Schema::dropIfExists('gallery_albums');
    }
};
