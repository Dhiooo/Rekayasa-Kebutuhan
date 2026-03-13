<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Alumni::insert([
            [
                'name' => 'John Doe',
                'study_program' => 'Informatika',
                'graduation_year' => 2022,
                'status' => 'Belum Dilacak',
                'confidence_score' => 0,
                'best_link' => null,
                'tracked_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jane Smith',
                'study_program' => 'Manajemen',
                'graduation_year' => 2021,
                'status' => 'Belum Dilacak',
                'confidence_score' => 0,
                'best_link' => null,
                'tracked_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'study_program' => 'Teknik Elektro',
                'graduation_year' => 2023,
                'status' => 'Belum Dilacak',
                'confidence_score' => 0,
                'best_link' => null,
                'tracked_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Aminah',
                'study_program' => 'Informatika',
                'graduation_year' => 2020,
                'status' => 'Belum Dilacak',
                'confidence_score' => 0,
                'best_link' => null,
                'tracked_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ahmad Rizal',
                'study_program' => 'Hukum',
                'graduation_year' => 2018,
                'status' => 'Belum Dilacak',
                'confidence_score' => 0,
                'best_link' => null,
                'tracked_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
