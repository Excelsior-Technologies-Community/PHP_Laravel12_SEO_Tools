<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
use App\Services\LiveSeoCrawlerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompetitorCompareController extends Controller
{
    /**
     * Compare two URLs side-by-side head-to-head.
     */
    public function compare(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'url_a' => 'required|url',
            'url_b' => 'required|url',
        ]);

        $crawler = new LiveSeoCrawlerService();
        $siteA = $crawler->inspectUrl($validated['url_a']);
        $siteB = $crawler->inspectUrl($validated['url_b']);

        // Determine winners per category
        $comparison = [
            'overall_score' => [
                'name' => 'SEO Health Score',
                'a' => $siteA['performance_score'],
                'b' => $siteB['performance_score'],
                'winner' => $siteA['performance_score'] > $siteB['performance_score'] ? 'A' : ($siteA['performance_score'] < $siteB['performance_score'] ? 'B' : 'Tie'),
            ],
            'word_count' => [
                'name' => 'Content Depth (Word Count)',
                'a' => $siteA['word_count'],
                'b' => $siteB['word_count'],
                'winner' => $siteA['word_count'] > $siteB['word_count'] ? 'A' : ($siteA['word_count'] < $siteB['word_count'] ? 'B' : 'Tie'),
            ],
            'speed_ttfb' => [
                'name' => 'Server Response Speed (TTFB)',
                'a' => $siteA['ttfb_ms'] . ' ms',
                'b' => $siteB['ttfb_ms'] . ' ms',
                'winner' => $siteA['ttfb_ms'] < $siteB['ttfb_ms'] ? 'A' : ($siteA['ttfb_ms'] > $siteB['ttfb_ms'] ? 'B' : 'Tie'),
            ],
            'h1_usage' => [
                'name' => 'H1 Heading Structure',
                'a' => !empty($siteA['h1_tag']) ? 'Single H1 (Proper)' : 'Missing H1',
                'b' => !empty($siteB['h1_tag']) ? 'Single H1 (Proper)' : 'Missing H1',
                'winner' => !empty($siteA['h1_tag']) && empty($siteB['h1_tag']) ? 'A' : (!empty($siteB['h1_tag']) && empty($siteA['h1_tag']) ? 'B' : 'Tie'),
            ],
            'image_alts' => [
                'name' => 'Image Alt Accessibility',
                'a' => $siteA['images_missing_alt'] . ' Missing Alts',
                'b' => $siteB['images_missing_alt'] . ' Missing Alts',
                'winner' => $siteA['images_missing_alt'] < $siteB['images_missing_alt'] ? 'A' : ($siteA['images_missing_alt'] > $siteB['images_missing_alt'] ? 'B' : 'Tie'),
            ],
            'schema_presence' => [
                'name' => 'Schema.org Structured Data',
                'a' => !empty($siteA['schema_data']) ? 'Detected' : 'None',
                'b' => !empty($siteB['schema_data']) ? 'Detected' : 'None',
                'winner' => !empty($siteA['schema_data']) && empty($siteB['schema_data']) ? 'A' : (!empty($siteB['schema_data']) && empty($siteA['schema_data']) ? 'B' : 'Tie'),
            ],
        ];

        return response()->json([
            'success' => true,
            'site_a' => $siteA,
            'site_b' => $siteB,
            'comparison' => $comparison,
        ]);
    }
}
