<?php

namespace App\Services;

use App\Models\Alumni;
use App\Services\GeminiService; // Added this line
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class AlumniTrackingService
{
    protected string $serperApiKey;
    protected GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->serperApiKey = env('SERPER_API_KEY', '');
        $this->gemini = $gemini;
    }

    /**
     * Perform tracking for a single Alumni
     */
    public function track(Alumni $alumni)
    {
        // 1) Initialize Target Profile
        $alumni->status = 'Belum Dilacak';
        $alumni->confidence_score = 0;
        $alumni->best_link = null;

        $univKeyword = "Universitas Muhammadiyah Malang";
        $univShort = "UMM";

        // 2) Generate Search Queries (Professional Platforms Priority)
        $queries = [
            // LinkedIn priority with full name and short name
            sprintf('site:linkedin.com/in/ "%s" ("Universitas Muhammadiyah Malang" OR "UMM")', $alumni->name),
            // Jobstreet / Professional Web
            sprintf('site:id.jobstreet.com "%s" "Muhammadiyah Malang"', $alumni->name),
            // Broad professional search without site restriction for one query to catch mixed profiles
            sprintf('"%s" "Universitas Muhammadiyah Malang" (LinkedIn OR Jobstreet OR Glints OR Portofolio)', $alumni->name),
            // Generic fallback with study program
            sprintf('"%s" "%s" "Universitas Muhammadiyah Malang"', $alumni->name, $alumni->study_program),
        ];

        $foundCandidates = [];

        // 3) Execute Search via Serper.dev
        foreach ($queries as $query) {
            $results = $this->simulateSearch($query, $alumni);
            $foundCandidates = array_merge($foundCandidates, $results);
            
            // Jika sudah menemukan kandidat yang sangat kuat di LinkedIn/Jobstreet, 
            // kita bisa berhenti lebih awal untuk hemat credit (Opsional, tapi untuk akurasi kita ambil semua)
        }

        // 4) Extract Signals & Scoring (Domain Priority + Gemini Analysis)
        if (!empty($foundCandidates)) {
            // Use Gemini for intelligent review of top 5 results to ensure UMM affiliation
            $topResults = array_slice($foundCandidates, 0, 5);
            $aiScore = $this->gemini->analyzeMatch(
                $alumni->name, 
                $univKeyword, 
                $alumni->study_program, 
                $topResults
            );
            
            // Check for professional links as a heuristic priority
            $hasProfessionalLink = false;
            foreach ($foundCandidates as $candidate) {
                $link = strtolower($candidate['link']);
                if (Str::contains($link, ['linkedin.com', 'jobstreet.co', 'glints.com', 'fiverr.com'])) {
                    $hasProfessionalLink = true;
                    $alumni->best_link = $candidate['link'];
                    break;
                }
            }

            if ($aiScore >= 2 || ($aiScore >= 1 && $hasProfessionalLink)) {
                // If AI confirms or we have high signal from professional platforms confirmed by AI
                $alumni->confidence_score = ($hasProfessionalLink) ? 3 : 2;
                if (!$alumni->best_link && !empty($foundCandidates)) {
                    $alumni->best_link = $foundCandidates[0]['link'];
                }
            } else if ($aiScore == 1) {
                $alumni->confidence_score = 1;
            } else {
                $alumni->confidence_score = 0;
            }
        }

        // 5) Set Final State
        if ($alumni->confidence_score === 3) {
            $alumni->status = 'Teridentifikasi (Scholar/Web)';
            $alumni->tracked_at = now();
        } elseif ($alumni->confidence_score >= 1) {
            $alumni->status = 'Perlu Verifikasi Manual';
            $alumni->tracked_at = now();
        } else {
            $alumni->status = 'Data Tidak Ditemukan';
            $alumni->tracked_at = now();
        }

        // 6) Update Database
        $alumni->save();

        return $alumni;
    }

    /**
     * Simulate Google Search API response for dummy data testing
     */
    private function simulateSearch(string $query, Alumni $alumni): array
    {
        // Panggil Serper.dev API
        $response = Http::withHeaders([
            'X-API-KEY' => $this->serperApiKey,
            'Content-Type' => 'application/json'
        ])->post('https://google.serper.dev/search', [
            'q' => $query,
            'gl' => 'id',
            'hl' => 'id',
            'num' => 5
        ]);

        $results = [];

        if ($response->successful() && isset($response['organic'])) {
            // Ambil maksimal 5 data pencarian organik
            foreach ($response['organic'] as $item) {
                $results[] = [
                    'title' => $item['title'] ?? '',
                    'snippet' => $item['snippet'] ?? '',
                    'link' => $item['link'] ?? ''
                ];
            }
        } else {
            // Jika ada limit / gagal, coba log ke storage/logs/laravel.log
            \Illuminate\Support\Facades\Log::warning('Gagal Memanggil Serper API: ' . $response->body());
        }

        // Beri delay 1 detik untuk menghindari Rate Limiting dari Serper
        sleep(1);

        return $results;
    }
}
