<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeoPageController;
use App\Http\Controllers\SeoAuditController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RobotsController;

Route::get('/', function () {
    return view('welcome');
});

// SEO Pages Routes
Route::resource('seo-pages', SeoPageController::class);

// SEO Audit Routes
Route::post('/seo-pages/{id}/audit', [SeoAuditController::class, 'auditPage'])
    ->name('seo-pages.audit');
Route::get('/seo-pages/{id}/history', [SeoAuditController::class, 'auditHistory'])
    ->name('seo-pages.history');

// Sitemap Routes
Route::get('/sitemap-generate', [SitemapController::class, 'generate'])
    ->name('sitemap.generate');
Route::get('/sitemap.xml', [SitemapController::class, 'view']);

// Robots.txt Routes
Route::get('/robots-generate', [RobotsController::class, 'generate'])
    ->name('robots.generate');
Route::get('/robots.txt', [RobotsController::class, 'view']);

// Dashboard Route
Route::get('/dashboard', function () {
    $totalPages = \App\Models\SeoPage::count();
    $averageScore = \App\Models\SeoPage::avg('performance_score') ?? 0;
    $recentAudits = \App\Models\SeoAuditLog::with('seoPage')
        ->latest()
        ->take(5)
        ->get();
    
    return view('dashboard', compact('totalPages', 'averageScore', 'recentAudits'));
})->name('dashboard');