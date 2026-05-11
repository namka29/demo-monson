<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('accommodation_type', 32)->default('other')->index();
            $table->text('description')->nullable();
            $table->string('address', 512)->nullable();
            $table->string('price_hint', 128)->nullable();
            $table->string('contact_phone', 32)->nullable();
            $table->string('image_url', 2048)->nullable();
            $table->string('status', 32)->default('draft')->index();
            $table->timestamps();
        });

        Schema::create('tour_suggestions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->text('body')->nullable();
            $table->unsignedTinyInteger('duration_days')->nullable();
            $table->text('highlights')->nullable();
            $table->string('image_url', 2048)->nullable();
            $table->string('status', 32)->default('draft')->index();
            $table->timestamps();
        });

        Schema::create('local_specialties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category', 32)->default('other')->index();
            $table->text('description')->nullable();
            $table->string('origin_hint', 255)->nullable();
            $table->string('image_url', 2048)->nullable();
            $table->string('status', 32)->default('draft')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('local_specialties');
        Schema::dropIfExists('tour_suggestions');
        Schema::dropIfExists('accommodations');
    }
};
