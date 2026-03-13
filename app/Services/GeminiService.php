<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.1-flash-lite-preview:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', env('GEMINI_API_KEY', ''));
    }

    /**
     * Analyze search snippets and confirm if they match the alumni.
     */
    public function analyzeMatch(string $name, string $university, string $prodi, array $snippets): int
    {
        if (empty($this->apiKey)) {
            Log::warning('Gemini API Key not set. Falling back to basic logic.');
            return -1; // Trigger fallback
        }

        $context = "";
        foreach ($snippets as $i => $s) {
            $context .= "Result " . ($i+1) . ":\nTitle: {$s['title']}\nSnippet: {$s['snippet']}\nLink: {$s['link']}\n\n";
        }

        $prompt = "
            You are an expert alumni tracking assistant. 
            I am looking for an alumni named '{$name}' from '{$university}' specifically from the '{$prodi}' program.
            
            Here are some search results from the web:
            {$context}
            
            Based on these snippets, verify if any of them likely belong to the person I'm looking for.
            Assign a score from 0 to 3 based on your confidence:
            3 - Very High: Definitely the right person (found on LinkedIn/Jobstreet/Professional site with matching university/prodi).
            2 - Medium: Likely the right person, but maybe only a PDF document or ambiguous mention at the right university.
            1 - Low: Only the name matches, but university is unclear or different.
            0 - No Match: Not the right person.
            
            Return ONLY a single integer (0, 1, 2, or 3) indicating the highest confidence found among these results.
        ";

        try {
            $response = Http::post("{$this->baseUrl}?key={$this->apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $result = trim($response->json('candidates.0.content.parts.0.text'));
                Log::info("Gemini Analysis Result for {$name}: {$result}");
                return is_numeric($result) ? (int)$result : 1;
            } else {
                Log::error("Gemini API Failure: " . $response->status() . " - " . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
        }

        return -1;
    }
}
