<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
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
            ->oldest()
            ->paginate(5)
            ->withQueryString();

        return view('seo-pages.index', compact('pages'));
    }

    /**
     * Create Page
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

            'page_url' => 'required|url|unique:seo_pages',

            'page_title' => 'required|max:60',

            'meta_description' => 'required|max:160',

            'meta_keywords' => 'nullable',

            'og_title' => 'nullable|max:60',

            'og_description' => 'nullable|max:160',

            'og_image' => 'nullable|url',

            'canonical_url' => 'nullable|url',

        ]);

        SeoPage::create($validated);

        return redirect()
            ->route('seo-pages.index')
            ->with('success', 'SEO Page created successfully.');
    }

    /**
     * Show Page
     */
    public function show(SeoPage $seoPage)
    {
        $latestAudit = $seoPage->auditLogs()
            ->latest()
            ->first();

        return view(
            'seo-pages.show',
            compact('seoPage', 'latestAudit')
        );
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
        $validated = $request->validate([

            'page_title' => 'required|max:60',

            'meta_description' => 'required|max:160',

            'meta_keywords' => 'nullable',

            'og_title' => 'nullable|max:60',

            'og_description' => 'nullable|max:160',

            'og_image' => 'nullable|url',

            'canonical_url' => 'nullable|url',

        ]);

        $seoPage->update($validated);

        return redirect()
            ->route('seo-pages.show', $seoPage)
            ->with('success', 'SEO Page updated successfully.');
    }

    /**
     * Delete Page
     */
    public function destroy(SeoPage $seoPage)
    {
        $seoPage->delete();

        return redirect()
            ->route('seo-pages.index')
            ->with('success', 'SEO Page deleted successfully.');
    }

    /**
     * Export CSV
     */
    public function exportCsv(): StreamedResponse
    {
        $fileName = 'seo-pages.csv';

        $pages = SeoPage::all();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () use ($pages) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [

                'ID',

                'Page URL',

                'Page Title',

                'Meta Description',

                'SEO Score',

                'Created At',

            ]);

            foreach ($pages as $page) {

                fputcsv($file, [

                    $page->id,

                    $page->page_url,

                    $page->page_title,

                    $page->meta_description,

                    $page->performance_score,

                    $page->created_at,

                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
