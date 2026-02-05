<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
use App\Models\SeoAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SeoAuditController extends Controller
{
    public function auditPage(Request $request, $id)
    {
        $seoPage = SeoPage::findOrFail($id);
        
        // Run multiple audits
        $audits = [
            'meta_tags' => $this->auditMetaTags($seoPage),
            'content_analysis' => $this->auditContent($seoPage),
            'performance' => $this->auditPerformance($seoPage->page_url),
        ];

        // Calculate overall score
        $overallScore = collect($audits)->avg('score');

        // Save audit log
        $auditLog = SeoAuditLog::create([
            'seo_page_id' => $seoPage->id,
            'audit_type' => 'full_audit',
            'audit_data' => $audits,
            'score' => $overallScore,
            'recommendations' => $this->generateRecommendations($audits),
        ]);

        // Update page with latest data
        $seoPage->update([
            'performance_score' => $overallScore,
            'word_count' => $audits['content_analysis']['word_count'] ?? 0,
        ]);

        return redirect()->route('seo-pages.show', $seoPage)
            ->with('success', 'SEO audit completed successfully.');
    }

    private function auditMetaTags(SeoPage $page): array
    {
        $score = 0;
        $issues = [];
        $passed = [];

        // Check title length
        $titleLength = strlen($page->page_title);
        if ($titleLength >= 50 && $titleLength <= 60) {
            $score += 25;
            $passed[] = 'Title length is optimal (50-60 characters)';
        } else {
            $issues[] = "Title should be 50-60 characters (currently {$titleLength})";
        }

        // Check meta description length
        $descLength = strlen($page->meta_description);
        if ($descLength >= 120 && $descLength <= 160) {
            $score += 25;
            $passed[] = 'Meta description length is optimal';
        } else {
            $issues[] = "Meta description should be 120-160 characters (currently {$descLength})";
        }

        // Check for H1
        if (!empty($page->h1_tag)) {
            $score += 25;
            $passed[] = 'H1 tag is present';
        } else {
            $issues[] = 'Missing H1 tag';
        }

        // Check for Open Graph tags
        if (!empty($page->og_title) && !empty($page->og_description)) {
            $score += 25;
            $passed[] = 'Open Graph tags are set';
        } else {
            $issues[] = 'Missing Open Graph tags';
        }

        return [
            'score' => $score,
            'issues' => $issues,
            'passed' => $passed,
        ];
    }

    private function auditContent(SeoPage $page): array
    {
        // Simulate content analysis
        $score = 80;
        $issues = [];
        $passed = ['Content structure looks good'];

        if ($page->word_count < 300) {
            $score -= 20;
            $issues[] = 'Content is too short (aim for 300+ words)';
        }

        if ($page->image_count === 0) {
            $score -= 10;
            $issues[] = 'No images found in content';
        }

        return [
            'score' => max($score, 0),
            'issues' => $issues,
            'passed' => $passed,
            'word_count' => $page->word_count,
            'image_count' => $page->image_count,
        ];
    }

    private function auditPerformance(string $url): array
    {
        // Simulate performance audit
        return [
            'score' => 75,
            'issues' => ['Consider optimizing images', 'Minify CSS/JS'],
            'passed' => ['Mobile responsive', 'Good server response time'],
        ];
    }

    private function generateRecommendations(array $audits): string
    {
        $recommendations = [];
        
        foreach ($audits as $audit) {
            if (!empty($audit['issues'])) {
                $recommendations = array_merge($recommendations, $audit['issues']);
            }
        }

        return implode("\n", array_slice($recommendations, 0, 5));
    }

    public function auditHistory($id)
    {
        $seoPage = SeoPage::with('auditLogs')->findOrFail($id);
        return view('seo-pages.history', compact('seoPage'));
    }
}