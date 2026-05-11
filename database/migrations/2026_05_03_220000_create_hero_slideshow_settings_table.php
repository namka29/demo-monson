<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hero_slideshow_settings', function (Blueprint $table): void {
            $table->id();
            /** 0 = không tự đổi slide; các giá trị > 0 là mili giây. */
            $table->unsignedInteger('autoplay_interval_ms')->default(6500);
            $table->timestamps();
        });

        DB::table('hero_slideshow_settings')->insert([
            'id' => 1,
            'autoplay_interval_ms' => 6500,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slideshow_settings');
    }
};
