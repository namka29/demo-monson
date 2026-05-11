<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('media_type', 32)->index();
            $table->text('image_url')->nullable();
            $table->string('image_disk_path')->nullable();
            $table->text('video_url')->nullable();
            $table->string('video_disk_path')->nullable();
            $table->string('youtube_video_id', 32)->nullable();
            $table->text('video_poster_url')->nullable();
            $table->string('video_poster_disk_path')->nullable();
            $table->boolean('is_active')->default(false)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_banners');
    }
};
