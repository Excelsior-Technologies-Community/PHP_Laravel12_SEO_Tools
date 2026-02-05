<?php

namespace App\Services;

use App\Models\SeoPage;
use Illuminate\Support\Facades\Http;

class SeoAnalyzerService
{
    public function analyzeMetaTags(SeoPage $page): array
    {
        $analysis = [
            'title' => $this->analyzeTitle($page->page_title),
            'meta_description' => $this->analyzeMetaDescription($page->meta_description),
            'h1' => $this->analyzeH1($page->h1_tag),
            'keywords' => $this->analyzeKeywords($page->meta_keywords),
        ];

        return $analysis;
    }

    private function analyzeTitle(string $title): array
    {
        $length = strlen($title);
        
        return [
            'length' => $length,
            'status' => $length >= 50 && $length <= 60 ? 'optimal' : ($length > 60 ? 'too_long' : 'too_short'),
            'score' => $length >= 50 && $length <= 60 ? 100 : max(0, 100 - abs($length - 55) * 2),
        ];
    }

    private function analyzeMetaDescription(string $description): array
    {
        $length = strlen($description);
        
        return [
            'length' => $length,
            'status' => $length >= 120 && $length <= 160 ? 'optimal' : ($length > 160 ? 'too_long' : 'too_short'),
            'score' => $length >= 120 && $length <= 160 ? 100 : max(0, 100 - abs($length - 140) * 0.5),
        ];
    }

    private function analyzeH1(?string $h1): array
    {
        if (empty($h1)) {
            return [
                'present' => false,
                'score' => 0,
                'status' => 'missing',
            ];
        }

        return [
            'present' => true,
            'count' => 1,
            'score' => 100,
            'status' => 'good',
        ];
    }

    private function analyzeKeywords(?string $keywords): array
    {
        if (empty($keywords)) {
            return [
                'present' => false,
                'score' => 50,
                'status' => 'not_set',
            ];
        }

        $keywordArray = explode(',', $keywords);
        $keywordCount = count($keywordArray);

        return [
            'present' => true,
            'count' => $keywordCount,
            'score' => min(100, $keywordCount * 10),
            'status' => $keywordCount <= 10 ? 'optimal' : 'too_many',
        ];
    }

    public function calculateOverallScore(array $analysis): float
    {
        $weights = [
            'title' => 0.3,
            'meta_description' => 0.3,
            'h1' => 0.2,
            'keywords' => 0.2,
        ];

        $totalScore = 0;
        foreach ($weights as $key => $weight) {
            $totalScore += ($analysis[$key]['score'] ?? 0) * $weight;
        }

        return round($totalScore, 2);
    }
}