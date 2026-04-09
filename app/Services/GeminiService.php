<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    /**
     * Menggunakan ?string agar tidak error "Cannot assign null" di PHP 8.2+ 
     * jika .env tidak terbaca di InfinityFree.
     */
    protected ?string $apiKey = null;
    protected string $model = 'gemini-1.5-flash';
    protected string $baseUrl = '';

    public function __construct()
    {
        // Ambil data dari config, jika kosong berikan string kosong agar tidak null
        $this->apiKey = config('services.gemini.key') ?? '';
        $this->model = config('services.gemini.model') ?? 'gemini-1.5-flash';
        
        // Base URL dibentuk di sini
        $this->baseUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    /**
     * FASE 1: Verifikasi LinkedIn
     * 
     * Tugas: Dari daftar hasil pencarian LinkedIn, tentukan MANA yang benar-benar
     * milik alumni UMM dengan nama yang PERSIS cocok.
     */
    public function verifyLinkedIn(string $name, string $university, string $prodi, array $linkedinResults): ?array
    {
        if (empty($this->apiKey)) {
            Log::warning('Gemini API Key is empty or null in verifyLinkedIn.');
            return ['linkedin_url' => null, 'is_umm_alumni' => false, 'reasoning' => 'API Key belum dikonfigurasi di server.'];
        }

        $context = "";
        foreach ($linkedinResults as $i => $s) {
            $context .= "Profile " . ($i+1) . ":\n";
            $context .= "  Title: {$s['title']}\n";
            $context .= "  Snippet: {$s['snippet']}\n";
            $context .= "  URL: {$s['link']}\n\n";
        }

        $prompt = <<<PROMPT
You are an ULTRA-STRICT identity verification assistant. You verify whether a LinkedIn profile belongs to a SPECIFIC alumni of Universitas Muhammadiyah Malang.

TARGET PERSON:
- Full Name: "{$name}"
- University: "{$university}" (abbreviation: "UMM")
- Study Program: "{$prodi}"

LINKEDIN SEARCH RESULTS:
{$context}

VERIFICATION RULES — FOLLOW THESE EXACTLY:

STEP 1 - NAME CHECK:
- The profile name MUST match "{$name}" exactly or very closely.
- If the name is completely different, REJECT immediately.

STEP 2 - UNIVERSITY CHECK (THIS IS THE MOST IMPORTANT STEP):
- You MUST find EXPLICIT evidence that this person attended "Universitas Muhammadiyah Malang" or "UMM".
- Accepted evidence: the snippet contains "Universitas Muhammadiyah Malang", "UMM", "Muhammadiyah Malang", or "University of Muhammadiyah Malang".
- REJECTED — if the snippet mentions ANY of these OTHER universities, the profile is NOT the right person:
  * Universitas Indonesia (UI)
  * Institut Teknologi Bandung (ITB)
  * Institut Teknologi Sepuluh Nopember (ITS)
  * Universitas Brawijaya (UB)
  * Universitas Gadjah Mada (UGM)
  * Universitas Airlangga (Unair)
  * Universitas Diponegoro (Undip)
  * Universitas Padjadjaran (Unpad)
  * Universitas Muhammadiyah Yogyakarta
  * Universitas Muhammadiyah Surakarta
  * Universitas Muhammadiyah Jakarta
  * Universitas Muhammadiyah Surabaya
  * ANY other university that is NOT "Universitas Muhammadiyah Malang"
- WARNING: "Muhammadiyah" alone is NOT enough! There are many Muhammadiyah universities in Indonesia. It MUST say "Malang" or "UMM" specifically.
- If there is NO mention of any university at all, set is_umm_alumni to false.

STEP 3 - COMMON NAME WARNING:
- Names like "Siti", "Muhammad", "Ahmad", "Putri", "Dewi" are very common in Indonesia.
- For common names, be EXTRA careful. Only accept if UMM evidence is CLEAR.
- If two profiles have the same name but different universities, REJECT both unless one clearly shows UMM.

Return ONLY valid JSON (no markdown, no text):
{
    "linkedin_url": "the URL of the verified profile, or null if none match",
    "is_umm_alumni": true or false,
    "reasoning": "brief explanation"
}
PROMPT;

        $result = $this->callGemini($prompt, "LinkedIn verification for {$name}");
        
        if ($result && isset($result['linkedin_url'])) {
            $validUrls = array_column($linkedinResults, 'link');
            if (!in_array($result['linkedin_url'], $validUrls)) {
                $result['linkedin_url'] = null;
                $result['is_umm_alumni'] = false;
            }
            return $result;
        }

        return null;
    }

    /**
     * FASE 2: Ekstraksi Data Alumni
     * 
     * Tugas: Dari SEMUA hasil pencarian, ekstrak 8 kategori data.
     * TAPI hanya jika data tersebut benar-benar milik orang yang SAMA.
     */
    public function extractAlumniData(
        string $name, 
        string $university, 
        string $prodi, 
        array $allResults,
        bool $isLinkedinVerified,
        ?string $verifiedLinkedinUrl
    ): array {
        if (empty($this->apiKey)) {
            Log::warning('Gemini API Key is empty or null in extractAlumniData.');
            return ['score' => -1, 'error' => 'API Key Gemini belum diset di server.'];
        }

        $context = "";
        foreach ($allResults as $i => $s) {
            $context .= "Result " . ($i+1) . ":\n";
            $context .= "  Title: {$s['title']}\n";
            $context .= "  Snippet: {$s['snippet']}\n";
            $context .= "  Link: {$s['link']}\n\n";
        }

        $nameNoSpaces = str_replace(' ', '', strtolower($name));
        $linkedinStatus = $isLinkedinVerified 
            ? "CONFIRMED: LinkedIn profile verified at {$verifiedLinkedinUrl}" 
            : "NOT CONFIRMED: No verified LinkedIn found for this person";

        $prompt = <<<PROMPT
You are an ADVANCED IDENTITY INVESTIGATOR. Your goal is to verify and extract data for a specific alumni of Universitas Muhammadiyah Malang (UMM) using 6 strategic search queries.

TARGET PERSON:
- Full Name: "{$name}"
- Handle Alias: "{$nameNoSpaces}"
- University: "{$university}" (UMM)
- Study Program: "{$prodi}"
- LinkedIn Verification Status: {$linkedinStatus}

SEARCH RESULTS (MAX 6 QUERIES):
{$context}

INVESTIGATION RULES:

1. HANDLE DISCOVERY (CRITICAL):
   - Look closely at the "Title" of each result.
   - Pattern to watch: `Name (@username) • Instagram` or `Naoval (@naopalism)`. 
   - If you see a handle in parentheses next to a name alias, extract that `@username` as the official profile handle for that platform.

2. CROSS-REFERENCE EVIDENCE:
   - Use results from Query 4 (Journals, UMM site, news) to confirm the person is a UMM alumni.
   - Once UMM affiliation is confirmed by evidence, you are AUTHORIZED to validate LinkedIn or Social Media profiles with the same name, even if the profiles don't mention UMM (e.g., they only list a current job).

3. TRACEBACK LOGIC:
   - If a search result is a post/video link (`/p/`, `/reels/`, `/watch`), extract the root account URL if the caption/title mentions "{$name}".
   - Put the specific post link in "social_evidence".

4. SCORING:
   - 3 = Confirmed match (Evidence-backed).
   - 2 = Likely match (Name + Context fits).
   - 1 = Weak match (Name only).
   - 0 = Different person.

ANTI-HALLUCINATION:
- ONLY use URLs from the "Link:" fields. 
- social_evidence: Return an array of the 3-5 most important links (Journals, Posts) that prove the identity.

Return ONLY valid JSON:
{
    "score": 0,
    "linkedin_url": null,
    "instagram_url": null,
    "facebook_url": null,
    "tiktok_url": null,
    "youtube_url": null,
    "email": null,
    "phone": null,
    "workplace": null,
    "workplace_address": null,
    "job_position": null,
    "employment_type": null,
    "workplace_social_media": null,
    "social_evidence": []
}
PROMPT;

        $result = $this->callGemini($prompt, "Data extraction for {$name}");
        return $result ?? ['score' => -1];
    }

    /**
     * Core Gemini API call with error handling
     */
    private function callGemini(string $prompt, string $context): ?array
    {
        if (empty($this->apiKey)) {
            Log::error("Gemini API Call failed: API Key is empty for [{$context}]");
            return null;
        }

        try {
            $response = Http::timeout(35)->post("{$this->baseUrl}?key={$this->apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $rawResult = trim($response->json('candidates.0.content.parts.0.text') ?? '');

                if (empty($rawResult)) {
                    Log::error("Gemini Response empty for [{$context}]");
                    return null;
                }

                // Clean markdown code blocks
                $rawResult = preg_replace('/^```(?:json)?\s*/', '', $rawResult);
                $rawResult = preg_replace('/\s*```$/', '', $rawResult);
                $rawResult = trim($rawResult);

                $result = json_decode($rawResult, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    Log::info("Gemini [{$context}]: Success");
                    return $result;
                } else {
                    Log::error("Gemini JSON error [{$context}]: " . json_last_error_msg() . " | Raw: " . substr($rawResult, 0, 500));
                }
            } else {
                Log::error("Gemini API error [{$context}]: HTTP {$response->status()} - " . substr($response->body(), 0, 300));
            }
        } catch (\Exception $e) {
            Log::error("Gemini exception [{$context}]: " . $e->getMessage());
        }

        return null;
    }
}
