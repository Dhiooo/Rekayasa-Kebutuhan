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
        if (config('database.default') === 'sqlite') {
            // SQLite handle: Recreate table to change column type and remove CHECK constraints
            \Illuminate\Support\Facades\DB::beginTransaction();
            try {
                // 1. Create temporary table with new schema (status as string)
                \Illuminate\Support\Facades\DB::statement("CREATE TABLE alumnis_temp (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    study_program TEXT NOT NULL,
                    graduation_year INTEGER NOT NULL,
                    status TEXT NOT NULL DEFAULT 'Belum Dilacak',
                    confidence_score INTEGER DEFAULT 0,
                    best_link TEXT,
                    tracked_at DATETIME,
                    created_at DATETIME,
                    updated_at DATETIME
                )");

                // 2. Copy data and map old status to new status
                \Illuminate\Support\Facades\DB::statement("INSERT INTO alumnis_temp (id, name, study_program, graduation_year, status, confidence_score, best_link, tracked_at, created_at, updated_at)
                    SELECT id, name, study_program, graduation_year, 
                    CASE 
                        WHEN status = 'Teridentifikasi (Scholar/Web)' THEN 'Teridentifikasi (Data Publik)'
                        WHEN status = 'Teridentifikasi (Professional Social Media)' THEN 'Teridentifikasi (Data Publik)'
                        ELSE status 
                    END,
                    confidence_score, best_link, tracked_at, created_at, updated_at FROM alumnis");

                // 3. Swap tables
                \Illuminate\Support\Facades\DB::statement("DROP TABLE alumnis");
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE alumnis_temp RENAME TO alumnis");

                \Illuminate\Support\Facades\DB::commit();
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\DB::rollBack();
                throw $e;
            }
        } else {
            // MySQL/Production behavior
            Schema::table('alumnis', function (Blueprint $table) {
                $table->string('status')->default('Belum Dilacak')->change();
            });

            \Illuminate\Support\Facades\DB::table('alumnis')
                ->where('status', 'Teridentifikasi (Scholar/Web)')
                ->orWhere('status', 'Teridentifikasi (Professional Social Media)')
                ->update(['status' => 'Teridentifikasi (Data Publik)']);
        }
    }

    public function down(): void
    {
        \Illuminate\Support\Facades\DB::update("UPDATE alumnis SET status = 'Teridentifikasi (Scholar/Web)' WHERE status = 'Teridentifikasi (Data Publik)'");
    }
};
