<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyllabusGeneratorService
{
    /**
     * Generate syllabus content for specific weeks using Google Gemini AI
     * 
     * @param string $courseTitle
     * @param string $courseCode
     * @param string $courseDescription
     * @param array $weeks Array of week numbers to generate (e.g., [1, 2, 3])
     * @param string|null $cmoYear
     * @param string|null $cmoTitle
     * @return array|null Structured syllabus content or null on failure
     */
    public function generateSyllabusContent(string $courseTitle, string $courseCode, string $courseDescription, array $weeks, ?string $cmoYear = null, ?string $cmoTitle = null): ?array
    {
        // Increase PHP execution time limit to 5 minutes to match the Guzzle timeout
        set_time_limit(300);

        try {
            $apiKey = config('services.gemini.api_key');
            $primaryModel = config('services.gemini.model', 'gemini-2.5-flash');
            
            // List of models to try in order of preference
            // Updated based on confirmed available models minus failing 404s
            $modelsToTry = array_unique([
                $primaryModel,
                'gemini-2.5-flash-lite', 
                'gemini-2.0-flash-lite-001',
                'gemini-2.0-flash',
                'gemini-flash-latest'
            ]);
            
            if (empty($apiKey)) {
                Log::warning('Gemini API key not configured for generation');
                return null;
            }
            
            $promptText = $this->buildSyllabusGenerationPrompt($courseTitle, $courseCode, $courseDescription, $weeks, $cmoYear, $cmoTitle);
            
            $response = null;
            $usedModel = '';
            $lastError = '';
            $lastStatusCode = 500;

            foreach ($modelsToTry as $currentModel) {
                try {
                    // Determine API version based on model
                    // gemini-pro is legacy and works best on v1
                    // newer flash/pro models are on v1beta
                    $apiVersion = ($currentModel === 'gemini-pro') ? 'v1' : 'v1beta';
                    
                    $url = "https://generativelanguage.googleapis.com/{$apiVersion}/models/{$currentModel}:generateContent?key={$apiKey}";
                    
                    Log::info("Attempting syllabus generation with model: {$currentModel} (Version: {$apiVersion})");
                    
                    $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                    ])->timeout(240)->post($url, [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $promptText]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'topK' => 40,
                            'topP' => 0.95,
                            'maxOutputTokens' => 8192,
                        ]
                    ]);

                    if ($response->successful()) {
                        $usedModel = $currentModel;
                        Log::info("Syllabus generation succeeded with model: {$currentModel}");
                        break; // Success! Exit loop
                    } else {
                        $lastStatusCode = $response->status();
                        $lastError = $response->body();
                        Log::warning("Gemini model {$currentModel} failed ({$lastStatusCode}): " . $lastError);
                        
                        // Small backoff before next model to avoid hitting rate limits instantly
                        sleep(1);
                    }
                } catch (\Exception $e) {
                     Log::warning("Gemini model {$currentModel} exception: " . $e->getMessage());
                     $lastError = $e->getMessage();
                }
            }

            if (!$response || $response->failed()) {
                Log::error('All Gemini models failed. Last error: ' . $lastError);
                // Return array with error info, not just null, so Controller can handle it?
                // But method signature says ?array. We'll rely on Controller to default to 500 equivalent, 
                // OR we can throw exception to be caught by controller.
                
                // Let's throw an exception with the specific code if it's 429
                if ($lastStatusCode === 429) {
                    throw new \Exception("Rate Limit Exceeded. Please try again in 1 minute.", 429);
                }
                
                return null; // Return null -> Controller sends 500
            }

            $responseData = $response->json();
            
            // Extract text from response structure
            $responseText = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';
            
            if (empty($responseText)) {
                Log::error('Gemini Direct API returned empty text');
                return null;
            }
            
            // Extract JSON from response
            $jsonText = $this->extractJson($responseText);
            
            $data = json_decode($jsonText, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Gemini prediction JSON decode error: ' . json_last_error_msg());
                // Log a snippet of the failed text for debugging
                Log::error('Failed Response Snippet: ' . substr($jsonText, 0, 500) . '...');
                return null;
            }
            
            Log::info('Gemini syllabus generation successful (Direct API - Isolated Service)');
            
            return $data;
            
        } catch (\Exception $e) {
            Log::error('Gemini syllabus generation failed (' . $e->getCode() . '): ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Build prompt for syllabus generation
     */
    private function buildSyllabusGenerationPrompt(string $courseTitle, string $courseCode, string $courseDescription, array $weeks, ?string $cmoYear = null, ?string $cmoTitle = null): string
    {
        $weeksStr = implode(', ', $weeks);
        $currentYear = date('Y');
        
        $cmoContext = "";
        if ($cmoYear || $cmoTitle) {
            $cmoContext = "Please ensure the content aligns specifically with the ";
            if ($cmoYear) $cmoContext .= "CHED Memorandum Order (CMO) Year {$cmoYear} ";
            if ($cmoTitle) $cmoContext .= "and the memorandum titled '{$cmoTitle}' ";
            $cmoContext .= "where applicable.";
        }

        return <<<PROMPT
You are an expert curriculum developer and academic syllabus generator. 
Your task is to generate high-quality, outcome-based education (OBE) syllabus content for a specific course, aligned with CHED (Commission on Higher Education) Memorandums and current trends for the year {$currentYear}.

{$cmoContext}

**Course Details:**
- **Course Title:** {$courseTitle}
- **Course Code:** {$courseCode}
- **Course Description:** {$courseDescription}

**Task:**
Generate detailed syllabus content for the following weeks: **{$weeksStr}**.

**Content Requirements per Week:**
For each week, provide the following fields:
1.  **Content (Topic):** The main topic or subject matter for the week.
2.  **Student Intended Learning Outcomes (SILOs):** Specific, measurable, attainable, relevant, and time-bound outcomes. Start with action verbs (e.g., "Analyze", "Evaluate", "Create").
3.  **Assessment Tasks (ATs):**
    *   **On-site:** Activities done in the classroom (e.g., "Quiz", "Oral Recitation", "Group Presentation").
    *   **Off-site:** Homework or assignments (e.g., "Research", "Reflection Paper").
4.  **Suggested Teaching/Learning Activities (TLAs):**
    *   **Face to Face (On-Site):** e.g., "Lecture", "Group Discussion", "Laboratory Work".
    *   **Online (Off-Site):** e.g., "Video Watching", "Online Reading", "LMS Quiz".
5.  **Learning and Teaching Support Materials (LTSM):** Educational resources (e.g., "Textbook", "Slides", "Video URL", "Software").
6.  **Output Materials:** Tangible outputs expected from students (e.g., "Worksheet", "Project Proposal", "Essay").

**Format:**
Return ONLY valid JSON (no markdown, no explanations) with the following structure, keyed by week number:

{
  "weeks": {
    "1": {
      "content": "...",
      "silo": "...",
      "at_onsite": "...",
      "at_offsite": "...",
      "tla_onsite": "...",
      "tla_offsite": "...",
      "ltsm": "...",
      "output": "..."
    },
    // ... other weeks
  }
}

**Tone and Quality:**
- Ensure the content is academic, professional, and aligned with standard curriculum guidelines.
- Make it relevant to the current year ({$currentYear}) and specific to the course description provided.
- Ensure progression of difficulty across the weeks if applicable.

Return ONLY the JSON object.
PROMPT;
    }

    /**
     * Extract JSON from response text (handles markdown code blocks)
     */
    private function extractJson(string $text): string
    {
        // Remove markdown code blocks if present
        $text = preg_replace('/```json\s*/', '', $text);
        $text = preg_replace('/```\s*/', '', $text);
        
        // Find the first opening brace and last closing brace
        $start = strpos($text, '{');
        $end = strrpos($text, '}');
        
        if ($start !== false && $end !== false) {
            $text = substr($text, $start, $end - $start + 1);
        }
        
        // Remove control characters (0-31) except newlines (10) and carriage returns (13) which might be needed? 
        // Actually, JSON strings shouldn't have raw newlines ideally, but `json_decode` handles them if distinct.
        // Let's strip standard non-printable control chars, maintaining standard whitespace.
        $text = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $text);
        
        return trim($text);
    }
}
