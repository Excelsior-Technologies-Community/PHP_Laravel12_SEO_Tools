<?php

namespace App\Http\Controllers;

use App\Models\SeoAuditLog;
use App\Models\SeoPage;
use App\Services\LiveSeoCrawlerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SeoPageController extends Controller
{
    /**
     * Display SEO Pages
     */
    public function index(Request $request)
    {
        $query = SeoPage::with('auditLogs');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('page_url', 'LIKE', "%{$search}%")
                    ->orWhere('page_title', 'LIKE', "%{$search}%")
                    ->orWhere('meta_description', 'LIKE', "%{$search}%");
            });
        }

        // SEO Score Filter
        if ($request->filled('score')) {
            switch ($request->score) {
                case 'excellent':
                    $query->where('performance_score', '>=', 80);
                    break;
                case 'good':
                    $query->whereBetween('performance_score', [60, 79]);
                    break;
                case 'poor':
                    $query->where('performance_score', '<', 60);
                    break;
                case 'not_audited':
                    $query->whereNull('performance_score');
                    break;
            }
        }

        $pages = $query
            ->latest()
            ->paginate(8)
            ->withQueryString();

        return view('seo-pages.index', compact('pages'));
    }

    /**
     * Create Page Form
     */
    public function create()
    {
        return view('seo-pages.create');
    }

    /**
     * Store Page
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_url' => 'required|url|unique:seo_pages,page_url',
            'page_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:500',
            'h1_tag' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'word_count' => 'nullable|integer|min:0',
            'image_count' => 'nullable|integer|min:0',
            'internal_links' => 'nullable|integer|min:0',
            'external_links' => 'nullable|integer|min:0',
        ]);

        $seoPage = SeoPage::create($validated);

        // Run automated audit on creation safely
        try {
            app(SeoAuditController::class)->performAudit($seoPage);
        } catch (\Throwable $e) {
            \Log::warning('Automatic audit on page create failed: ' . $e->getMessage());
        }

        return redirect()
            ->route('seo-pages.show', $seoPage)
            ->with('success', 'SEO Page created successfully.');
    }

    /**
     * Show Page Details
     */
    public function show(SeoPage $seoPage)
    {
        $seoPage->load('auditLogs');
        $latestAudit = $seoPage->auditLogs()->latest()->first();

        return view('seo-pages.show', compact('seoPage', 'latestAudit'));
    }

    /**
     * Edit Page
     */
    public function edit(SeoPage $seoPage)
    {
        return view('seo-pages.edit', compact('seoPage'));
    }

    /**
     * Update Page
     */
    public function update(Request $request, SeoPage $seoPage)
    {
        // Fallback to existing page_url if omitted
        if (!$request->filled('page_url')) {
            $request->merge(['page_url' => $seoPage->page_url]);
        }

        $validated = $request->validate([
            'page_url' => 'required|url|unique:seo_pages,page_url,' . $seoPage->id,
            'page_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:500',
            'h1_tag' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'og_title' => 'nullable|string|max:255',
            'og_description' => 'nullable|string|max:500',
            'og_image' => 'nullable|string|max:255',
            'canonical_url' => 'nullable|string|max:255',
            'word_count' => 'nullable|integer|min:0',
            'image_count' => 'nullable|integer|min:0',
            'internal_links' => 'nullable|integer|min:0',
            'external_links' => 'nullable|integer|min:0',
        ]);

        $seoPage->update($validated);

        return redirect()
            ->route('seo-pages.show', $seoPage)
            ->with('success', 'SEO Page updated successfully.');
    }

    /**
     * Destroy Page
     */
    public function destroy(SeoPage $seoPage)
    {
        $seoPage->delete();

        return redirect()
            ->route('seo-pages.index')
            ->with('success', 'SEO Page deleted successfully.');
    }

    /**
     * 1-Click Live Website Crawler & URL DOM Inspector endpoint.
     */
    public function crawl(Request $request): JsonResponse
    {
        $request->validate([
            'url' => 'required|url',
            'save' => 'nullable|boolean',
        ]);

        $crawler = new LiveSeoCrawlerService();
        $inspection = $crawler->inspectUrl($request->url);

        $savedPageId = null;

        if ($request->boolean('save')) {
            $page = SeoPage::updateOrCreate(
                ['page_url' => $inspection['url']],
                [
                    'page_title' => $inspection['page_title'] ?: 'Untitled Page',
                    'meta_description' => $inspection['meta_description'] ?: 'No description provided',
                    'meta_keywords' => $inspection['meta_keywords'],
                    'canonical_url' => $inspection['canonical_url'],
                    'og_title' => $inspection['og_title'],
                    'og_description' => $inspection['og_description'],
                    'og_image' => $inspection['og_image'],
                    'h1_tag' => $inspection['h1_tag'],
                    'h2_tags' => $inspection['h2_tags'],
                    'word_count' => $inspection['word_count'],
                    'image_count' => $inspection['image_count'],
                    'images_missing_alt' => $inspection['images_missing_alt'],
                    'internal_links' => $inspection['internal_links'],
                    'external_links' => $inspection['external_links'],
                    'performance_score' => $inspection['performance_score'],
                    'ttfb_ms' => $inspection['ttfb_ms'],
                    'page_weight_kb' => $inspection['page_weight_kb'],
                    'load_time_ms' => $inspection['load_time_ms'],
                    'gzip_enabled' => $inspection['gzip_enabled'],
                    'ssl_valid' => $inspection['ssl_valid'],
                    'http_status' => $inspection['http_status'],
                    'reading_time_min' => $inspection['reading_time_min'],
                    'links_data' => $inspection['links_data'],
                    'core_web_vitals' => $inspection['core_web_vitals'],
                ]
            );

            // Log the audit
            SeoAuditLog::create([
                'seo_page_id' => $page->id,
                'audit_type' => 'live_crawler_audit',
                'audit_data' => $inspection,
                'score' => $inspection['performance_score'],
                'recommendations' => implode("\n", array_merge($inspection['audit_summary']['critical_errors'], $inspection['audit_summary']['warnings'])),
            ]);

            $savedPageId = $page->id;
        }

        return response()->json([
            'success' => true,
            'data' => $inspection,
            'page_id' => $savedPageId,
            'message' => 'Live URL crawled and inspected successfully.'
        ]);
    }

    /**
     * Executive White-Label Printable SEO Audit Report Card.
     */
    public function report(SeoPage $seoPage)
    {
        $seoPage->load('auditLogs');
        $latestAudit = $seoPage->auditLogs()->latest()->first();

        return view('seo-pages.report', compact('seoPage', 'latestAudit'));
    }

    /**
     * Export CSV
     */
    public function exportCsv(): StreamedResponse
    {
        $pages = SeoPage::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="seo_pages_' . date('Y-m-d_H-i-s') . '.csv"',
        ];

        $callback = function () use ($pages) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID',
                'Page URL',
                'Title',
                'Score',
                'Word Count',
                'Images',
                'Missing Alts',
                'Internal Links',
                'External Links',
                'TTFB (ms)',
                'Page Weight (KB)',
                'SSL',
                'HTTP Status',
                'Created At'
            ]);

            foreach ($pages as $page) {
                fputcsv($handle, [
                    $page->id,
                    $page->page_url,
                    $page->page_title,
                    $page->performance_score ?? 0,
                    $page->word_count ?? 0,
                    $page->image_count ?? 0,
                    $page->images_missing_alt ?? 0,
                    $page->internal_links ?? 0,
                    $page->external_links ?? 0,
                    $page->ttfb_ms ?? 0,
                    $page->page_weight_kb ?? 0,
                    $page->ssl_valid ? 'Yes' : 'No',
                    $page->http_status ?? 200,
                    $page->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
