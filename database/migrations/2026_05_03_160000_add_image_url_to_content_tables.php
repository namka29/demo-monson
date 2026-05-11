<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('image_url', 2048)->nullable()->after('description');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->string('image_url', 2048)->nullable()->after('description');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('image_url', 2048)->nullable()->after('excerpt');
        });
    }

    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
};
