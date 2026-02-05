<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
use Illuminate\Http\Request;

class SeoPageController extends Controller
{
    public function index()
    {
        $pages = SeoPage::with('auditLogs')->paginate(10);
        return view('seo-pages.index', compact('pages'));
    }

    public function create()
    {
        return view('seo-pages.create');
    }

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

        return redirect()->route('seo-pages.index')
            ->with('success', 'SEO page created successfully.');
    }

    public function show(SeoPage $seoPage)
    {
        $latestAudit = $seoPage->auditLogs()->latest()->first();
        return view('seo-pages.show', compact('seoPage', 'latestAudit'));
    }

    public function edit(SeoPage $seoPage)
    {
        return view('seo-pages.edit', compact('seoPage'));
    }

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

        return redirect()->route('seo-pages.show', $seoPage)
            ->with('success', 'SEO page updated successfully.');
    }

    public function destroy(SeoPage $seoPage)
    {
        $seoPage->delete();
        return redirect()->route('seo-pages.index')
            ->with('success', 'SEO page deleted successfully.');
    }
}