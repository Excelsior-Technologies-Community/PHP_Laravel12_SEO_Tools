<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function generate()
    {
        $sitemap = Sitemap::create();

        // Add static pages
        $sitemap->add(Url::create('/')
            ->setPriority(1.0)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

        $sitemap->add(Url::create('/about')
            ->setPriority(0.8)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        // Add dynamic SEO pages
        $seoPages = SeoPage::all();
        foreach ($seoPages as $page) {
            $sitemap->add(Url::create($page->page_url)
                ->setLastModificationDate($page->updated_at)
                ->setPriority(0.9)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));

        return redirect()->back()
            ->with('success', 'Sitemap generated successfully.');
    }

    public function view()
    {
        return response()->file(public_path('sitemap.xml'));
    }
}