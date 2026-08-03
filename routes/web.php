<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeoPageController;
use App\Http\Controllers\SeoAuditController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\DashboardController;

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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

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


Route::post(
    '/seo-pages/bulk-audit',
    [SeoAuditController::class, 'bulkAudit']
)->name('seo-pages.bulk-audit');

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
