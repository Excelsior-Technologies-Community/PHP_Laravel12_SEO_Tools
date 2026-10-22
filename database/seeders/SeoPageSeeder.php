<?php

namespace Database\Seeders;

use App\Models\SeoAuditLog;
use App\Models\SeoPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class SeoPageSeeder extends Seeder
{
    public function run(): void
    {
        // Clean existing
        Schema::disableForeignKeyConstraints();
        SeoAuditLog::truncate();
        SeoPage::truncate();
        Schema::enableForeignKeyConstraints();

        // 1. Excellent A+ Page
        $page1 = SeoPage::create([
            'page_url' => 'https://example.com/ultimate-laravel-12-seo-guide',
            'page_title' => 'Ultimate Laravel 12 SEO Guide: Modern Optimization Secrets',
            'meta_description' => 'Discover battle-tested techniques to optimize Laravel 12 web applications for top Google SERP rankings with Core Web Vitals and Schema markup.',
            'meta_keywords' => 'laravel 12, seo tools, google serp, core web vitals, schema markup',
            'og_title' => 'Ultimate Laravel 12 SEO Guide: Modern Optimization Secrets',
            'og_description' => 'Discover battle-tested techniques to optimize Laravel 12 web applications for top Google SERP rankings.',
            'og_image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200',
            'canonical_url' => 'https://example.com/ultimate-laravel-12-seo-guide',
            'json_ld' => [
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => 'Ultimate Laravel 12 SEO Guide',
                'author' => ['@type' => 'Organization', 'name' => 'SEO Masters'],
            ],
            'h1_tag' => 'The Complete Laravel 12 Technical SEO Blueprint',
            'h2_tags' => [
                'Understanding Core Web Vitals in Laravel',
                'Automating Dynamic XML Sitemaps with Spatie',
                'Implementing JSON-LD Rich Snippets',
                'Robots.txt Best Practices for Crawl Budget',
            ],
            'word_count' => 1850,
            'image_count' => 8,
            'images_missing_alt' => 0,
            'internal_links' => 18,
            'external_links' => 6,
            'performance_score' => 96,
            'ttfb_ms' => 95.0,
            'page_weight_kb' => 32.4,
            'load_time_ms' => 240.0,
            'gzip_enabled' => true,
            'ssl_valid' => true,
            'http_status' => 200,
            'reading_time_min' => 9,
            'links_data' => [
                'internal' => 18,
                'external' => 6,
                'nofollow' => 4,
                'dofollow' => 20,
            ],
            'core_web_vitals' => [
                'lcp' => ['value' => '1.4s', 'status' => 'Good', 'score' => 98],
                'fid' => ['value' => '32ms', 'status' => 'Good', 'score' => 99],
                'cls' => ['value' => 0.01, 'status' => 'Good', 'score' => 98],
            ]
        ]);

        SeoAuditLog::create([
            'seo_page_id' => $page1->id,
            'audit_type' => 'full_live_audit',
            'audit_data' => [
                'ttfb' => 95,
                'score' => 96,
                'lcp' => '1.4s',
                'status' => 200,
            ],
            'score' => 96,
            'recommendations' => "Passed all Core Web Vitals benchmarks.\nTitle and Meta Description lengths are within optimal limits.\nAll image alt tags are properly specified.\nClean single H1 tag hierarchy.",
        ]);

        // 2. Good / Moderate B Grade Page
        $page2 = SeoPage::create([
            'page_url' => 'https://example.com/pricing-plans',
            'page_title' => 'Affordable SEO Tools Pricing & Enterprise Subscriptions',
            'meta_description' => 'Explore flexible monthly and annual plans for our automated SEO crawling suite. Start your 14-day free trial today.',
            'meta_keywords' => 'pricing, seo plans, subscriptions',
            'og_title' => 'Affordable SEO Tools Pricing',
            'og_description' => 'Explore flexible plans for our automated SEO suite.',
            'og_image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200',
            'canonical_url' => 'https://example.com/pricing-plans',
            'json_ld' => null,
            'h1_tag' => 'Transparent Pricing for Growing Teams',
            'h2_tags' => ['Starter Plan', 'Agency Suite', 'Enterprise Dedicated'],
            'word_count' => 620,
            'image_count' => 4,
            'images_missing_alt' => 2,
            'internal_links' => 8,
            'external_links' => 2,
            'performance_score' => 78,
            'ttfb_ms' => 185.0,
            'page_weight_kb' => 48.0,
            'load_time_ms' => 410.0,
            'gzip_enabled' => true,
            'ssl_valid' => true,
            'http_status' => 200,
            'reading_time_min' => 3,
            'links_data' => [
                'internal' => 8,
                'external' => 2,
                'nofollow' => 1,
                'dofollow' => 9,
            ],
            'core_web_vitals' => [
                'lcp' => ['value' => '2.8s', 'status' => 'Needs Improvement', 'score' => 75],
                'fid' => ['value' => '65ms', 'status' => 'Good', 'score' => 88],
                'cls' => ['value' => 0.06, 'status' => 'Good', 'score' => 80],
            ]
        ]);

        SeoAuditLog::create([
            'seo_page_id' => $page2->id,
            'audit_type' => 'full_live_audit',
            'audit_data' => [
                'ttfb' => 185,
                'score' => 78,
                'lcp' => '2.8s',
                'status' => 200,
            ],
            'score' => 78,
            'recommendations' => "2 images are missing descriptive ALT attributes.\nLCP is slightly elevated (2.8s). Consider image compression.\nAdd Product/Offer Schema markup to enable price snippets in search.",
        ]);

        // 3. Page with Critical Issues (C Grade)
        $page3 = SeoPage::create([
            'page_url' => 'https://example.com/about-us-team',
            'page_title' => 'About Us',
            'meta_description' => 'Company team.',
            'meta_keywords' => '',
            'og_title' => null,
            'og_description' => null,
            'og_image' => null,
            'canonical_url' => 'https://example.com/about-us-team',
            'json_ld' => null,
            'h1_tag' => null,
            'h2_tags' => ['Leadership', 'Office Locations'],
            'word_count' => 180,
            'image_count' => 6,
            'images_missing_alt' => 5,
            'internal_links' => 3,
            'external_links' => 0,
            'performance_score' => 48,
            'ttfb_ms' => 480.0,
            'page_weight_kb' => 85.0,
            'load_time_ms' => 890.0,
            'gzip_enabled' => false,
            'ssl_valid' => true,
            'http_status' => 200,
            'reading_time_min' => 1,
            'links_data' => [
                'internal' => 3,
                'external' => 0,
                'nofollow' => 0,
                'dofollow' => 3,
            ],
            'core_web_vitals' => [
                'lcp' => ['value' => '4.2s', 'status' => 'Poor', 'score' => 45],
                'fid' => ['value' => '120ms', 'status' => 'Needs Improvement', 'score' => 65],
                'cls' => ['value' => 0.18, 'status' => 'Poor', 'score' => 40],
            ]
        ]);

        SeoAuditLog::create([
            'seo_page_id' => $page3->id,
            'audit_type' => 'full_live_audit',
            'audit_data' => [
                'ttfb' => 480,
                'score' => 48,
                'lcp' => '4.2s',
                'status' => 200,
            ],
            'score' => 48,
            'recommendations' => "Critical: Title tag is too short (8 characters).\nCritical: Meta description is only 13 characters (target 120-160).\nMissing H1 heading on the page.\n5 out of 6 images lack ALT tags.\nGzip compression is disabled on the web server.",
        ]);
    }
}
