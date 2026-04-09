<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AlumniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Alumni::truncate(); // Wipe current data

        $alumniData = [
            [
                'name' => 'Mochammad Eriza Anwar',
                'study_program' => 'Informatika',
                'graduation_year' => 2024,
                'status' => 'Belum Dilacak',
            ],
            [
                'name' => 'Dhio Cho',
                'study_program' => 'Informatika',
                'graduation_year' => 2024,
                'status' => 'Belum Dilacak',
            ],
            [
                'name' => 'Azka Ryan Pradana',
                'study_program' => 'Informatika',
                'graduation_year' => 2024,
                'status' => 'Belum Dilacak',
            ],
        ];

        foreach ($alumniData as $data) {
            \App\Models\Alumni::create(array_merge($data, [
                'confidence_score' => 0,
                'best_link' => null,
                'tracked_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]));
        }
    }
}
