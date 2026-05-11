<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hero_banners', function (Blueprint $table): void {
            $table->unsignedSmallInteger('sort_order')->default(0)->after('is_active')->index();
        });

        $n = 0;
        foreach (DB::table('hero_banners')->orderBy('id')->pluck('id') as $id) {
            DB::table('hero_banners')->where('id', $id)->update(['sort_order' => $n++]);
        }
    }

    public function down(): void
    {
        Schema::table('hero_banners', function (Blueprint $table): void {
            $table->dropColumn('sort_order');
        });
    }
};
