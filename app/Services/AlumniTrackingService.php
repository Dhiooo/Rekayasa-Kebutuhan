<?php

namespace App\Services;

use App\Models\Alumni;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
     * ALGORITMA PELACAKAN ALUMNI (Digital Detective Version)
     * 
     * 1. LinkedIn Verification (Source of Truth)
     * 2. Multi-Platform Search (Handles, Profiles, and Mentions in Posts/Videos)
     * 3. AI Extraction & Cross-Verification
     * 4. Digital Evidence Collection
     */
    public function track(Alumni $alumni)
    {
        // 1) Reset data tracking
        $alumni->confidence_score = 0;
        $alumni->best_link = null;
        $alumni->linkedin_url = null;
        $alumni->instagram_url = null;
        $alumni->facebook_url = null;
        $alumni->tiktok_url = null;
        $alumni->youtube_url = null;
        $alumni->email = null;
        $alumni->phone = null;
        $alumni->workplace = null;
        $alumni->workplace_address = null;
        $alumni->job_position = null;
        $alumni->employment_type = null;
        $alumni->workplace_social_media = null;
        $alumni->social_evidence = null;

        $nameVariant = str_replace(' ', '', strtolower($alumni->name));

        // ============================================================
        // TAHAP 1: STRATEGI 6 KUERI (DEEP TRACKING)
        // ============================================================
        
        $allResults = [];

        // Kueri 1: LinkedIn Anchor
        $q1 = sprintf('site:linkedin.com/in/ "%s" ("Universitas Muhammadiyah Malang" OR "UMM")', $alumni->name);
        $allResults = array_merge($allResults, $this->searchSerper($q1));

        // Kueri 2: LinkedIn Backup (Broad)
        $q2 = sprintf('site:linkedin.com/in/ "%s"', $alumni->name);
        $allResults = array_merge($allResults, $this->searchSerper($q2));

        // Kueri 3: Social Profile Match
        $q3 = sprintf('("%s" OR "%s") (site:instagram.com OR site:facebook.com OR site:tiktok.com) profile', $alumni->name, $nameVariant);
        $allResults = array_merge($allResults, $this->searchSerper($q3));

        // Kueri 4: Social Traceback (Penemuan Handle via Postingan)
        $q4 = sprintf('("%s" OR "%s") (site:instagram.com OR site:youtube.com OR site:tiktok.com)', $alumni->name, $nameVariant);
        $allResults = array_merge($allResults, $this->searchSerper($q4));

        // Kueri 5: Academic Evidence (Jurnal & Berita)
        $q5 = sprintf('"%s" (site:umm.ac.id OR site:kompasiana.com OR site:jurnalpost.com OR "wisuda" OR "prestasi")', $alumni->name);
        $allResults = array_merge($allResults, $this->searchSerper($q5));

        // Kueri 6: Contact & Career Hunt
        $q6 = sprintf('"%s" ("@gmail.com" OR "works at" OR "bekerja" OR "phone" OR "whatsapp")', $alumni->name);
        $allResults = array_merge($allResults, $this->searchSerper($q6));

        // Deduplicate
        $unique = [];
        foreach ($allResults as $r) {
            $unique[$r['link']] = $r;
        }
        $allResults = array_values($unique);

        if (empty($allResults)) {
            $alumni->status = 'Data Tidak Ditemukan';
            $alumni->tracked_at = \Illuminate\Support\Carbon::now();
            $alumni->save();
            return $alumni;
        }

        // Filter LinkedIn for initial verification
        $linkedinResults = array_filter($allResults, function($r) {
            return Str::contains(strtolower($r['link']), 'linkedin.com/in/');
        });

        // Verifikasi LinkedIn
        $verifiedLinkedin = null;
        if (!empty($linkedinResults)) {
            $verifiedLinkedin = $this->gemini->verifyLinkedIn($alumni->name, 'Universitas Muhammadiyah Malang', $alumni->study_program, $linkedinResults);
        }

        $isLinkedinVerified = ($verifiedLinkedin && !empty($verifiedLinkedin['linkedin_url']) && ($verifiedLinkedin['is_umm_alumni'] ?? false));

        // ============================================================
        // FASE 3: ANALISIS GABUNGAN DENGAN GEMINI
        // ============================================================

        $aiData = $this->gemini->extractAlumniData(
            $alumni->name,
            'Universitas Muhammadiyah Malang',
            $alumni->study_program,
            array_slice($allResults, 0, 25), 
            $isLinkedinVerified,
            $verifiedLinkedin['linkedin_url'] ?? null
        );

        $aiScore = $aiData['score'] ?? 0;

        // ============================================================
        // FASE 4: SIMPAN DATA & BUKTI DIGITAL
        // ============================================================

        if ($aiScore >= 1) {
            $validLinks = array_column($allResults, 'link');

            $validateUrl = function ($url) use ($validLinks): ?string {
                if (empty($url)) return null;
                if (is_array($url)) $url = $url[0] ?? null;
                if (!$url || !is_string($url)) return null;
                return in_array($url, $validLinks) ? $url : null;
            };

            // Simpan Link Utama
            if ($isLinkedinVerified) {
                $alumni->linkedin_url = $verifiedLinkedin['linkedin_url'];
                $alumni->best_link = $verifiedLinkedin['linkedin_url'];
            } elseif (!empty($aiData['linkedin_url'])) {
                $alumni->linkedin_url = $validateUrl($aiData['linkedin_url']);
                if ($alumni->linkedin_url) $alumni->best_link = $alumni->linkedin_url;
            }

            $alumni->instagram_url = $validateUrl($aiData['instagram_url'] ?? null);
            $alumni->facebook_url = $validateUrl($aiData['facebook_url'] ?? null);
            $alumni->tiktok_url = $validateUrl($aiData['tiktok_url'] ?? null);
            $alumni->youtube_url = $validateUrl($aiData['youtube_url'] ?? null);

            // Simpan Data Teks
            $alumni->email = $aiData['email'] ?? null;
            $alumni->phone = $aiData['phone'] ?? null;
            $alumni->workplace = $aiData['workplace'] ?? null;
            $alumni->workplace_address = $aiData['workplace_address'] ?? null;
            $alumni->job_position = $aiData['job_position'] ?? null;
            $alumni->employment_type = $aiData['employment_type'] ?? null;
            $alumni->workplace_social_media = $aiData['workplace_social_media'] ?? null;

            // Simpan Bukti Digital (Social Evidence)
            if (!empty($aiData['social_evidence']) && is_array($aiData['social_evidence'])) {
                $alumni->social_evidence = array_filter($aiData['social_evidence'], function($link) use ($validLinks) {
                    return in_array($link, $validLinks);
                });
            }
        }

        // Penentuan Status
        $hasAnyRealData = (
            !empty($alumni->linkedin_url) ||
            !empty($alumni->instagram_url) ||
            !empty($alumni->facebook_url) ||
            !empty($alumni->email) ||
            !empty($alumni->workplace) ||
            !empty($alumni->youtube_url)
        );

        if ($isLinkedinVerified && $hasAnyRealData) {
            $alumni->confidence_score = 3;
            $alumni->status = 'Teridentifikasi (Data Publik)';
        } elseif ($hasAnyRealData && $aiScore >= 2) {
            $alumni->confidence_score = 2;
            $alumni->status = 'Perlu Verifikasi Manual';
        } else {
            $alumni->confidence_score = 0;
            $alumni->status = 'Data Tidak Ditemukan';
        }

        $alumni->tracked_at = \Illuminate\Support\Carbon::now();
        $alumni->save();

        return $alumni;
    }

    private function searchSerper(string $query): array
    {
        if (empty($this->serperApiKey)) {
            Log::warning('Serper API Key not set.');
            return [];
        }

        try {
            $response = Http::timeout(30)
                ->withHeaders(['X-API-KEY' => $this->serperApiKey, 'Content-Type' => 'application/json'])
                ->post('https://google.serper.dev/search', ['q' => $query, 'gl' => 'id', 'hl' => 'id']);

            if ($response->successful()) {
                return $response->json('organic') ?? [];
            }
        } catch (\Exception $e) {
            Log::error("Serper error: " . $e->getMessage());
        }

        return [];
    }
}
