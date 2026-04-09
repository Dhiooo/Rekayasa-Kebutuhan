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
        Schema::table('alumnis', function (Blueprint $table) {
            $table->string('linkedin_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('workplace')->nullable();
            $table->string('workplace_address')->nullable();
            $table->string('job_position')->nullable();
            $table->string('employment_type')->nullable(); // PNS, Swasta, Wirausaha
            $table->string('workplace_social_media')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alumnis', function (Blueprint $table) {
            $table->dropColumn([
                'linkedin_url', 'instagram_url', 'facebook_url', 'tiktok_url',
                'email', 'phone', 'workplace', 'workplace_address', 
                'job_position', 'employment_type', 'workplace_social_media'
            ]);
        });
    }
};
