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
        if (!Schema::hasColumn('alumnis', 'youtube_url')) {
            Schema::table('alumnis', function (Blueprint $table) {
                $table->string('youtube_url')->nullable();
            });
        }

        if (!Schema::hasColumn('alumnis', 'social_evidence')) {
            Schema::table('alumnis', function (Blueprint $table) {
                $table->text('social_evidence')->nullable(); // Store JSON array of proof links
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->dropColumn(['youtube_url', 'social_evidence']);
        });
    }
};
