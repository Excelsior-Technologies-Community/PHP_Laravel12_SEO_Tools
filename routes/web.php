<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeoPageController;
use App\Http\Controllers\SeoAuditController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RobotsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $totalPages = \App\Models\SeoPage::count();

    $totalAudits = \App\Models\SeoAuditLog::count();

    $averageScore = round(
        \App\Models\SeoPage::whereNotNull('performance_score')
            ->avg('performance_score') ?? 0,
        1
    );

    $bestScore = \App\Models\SeoPage::max('performance_score') ?? 0;

    $pagesWithoutAudit = \App\Models\SeoPage::whereNull('performance_score')->count();

    $recentAudits = \App\Models\SeoAuditLog::with('seoPage')
        ->oldest()
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'totalPages',
        'totalAudits',
        'averageScore',
        'bestScore',
        'pagesWithoutAudit',
        'recentAudits'
    ));
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| SEO Pages
|--------------------------------------------------------------------------
*/

Route::resource('seo-pages', SeoPageController::class);

/*
|--------------------------------------------------------------------------
| Export CSV
|--------------------------------------------------------------------------
*/

Route::get(
    '/seo-pages-export',
    [SeoPageController::class, 'exportCsv']
)->name('seo-pages.export');

/*
|--------------------------------------------------------------------------
| SEO Audit
|--------------------------------------------------------------------------
*/

Route::post(
    '/seo-pages/{id}/audit',
    [SeoAuditController::class, 'auditPage']
)->name('seo-pages.audit');

Route::get(
    '/seo-pages/{id}/history',
    [SeoAuditController::class, 'auditHistory']
)->name('seo-pages.history');

/*
|--------------------------------------------------------------------------
| Sitemap
|--------------------------------------------------------------------------
*/

Route::get(
    '/sitemap-generate',
    [SitemapController::class, 'generate']
)->name('sitemap.generate');

Route::get(
    '/sitemap.xml',
    [SitemapController::class, 'view']
);

/*
|--------------------------------------------------------------------------
| Robots
|--------------------------------------------------------------------------
*/

Route::get(
    '/robots-generate',
    [RobotsController::class, 'generate']
)->name('robots.generate');

Route::get(
    '/robots.txt',
    [RobotsController::class, 'view']
);
