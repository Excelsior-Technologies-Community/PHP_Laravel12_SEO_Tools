<?php

namespace App\Http\Controllers;

use App\Models\SeoPage;
use App\Models\SeoAuditLog;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPages = SeoPage::count();

        $totalAudits = SeoAuditLog::count();

        $averageScore = round(
            SeoPage::whereNotNull('performance_score')
                ->avg('performance_score') ?? 0,
            1
        );

        $bestScore = SeoPage::max('performance_score') ?? 0;

        $pagesWithoutAudit = SeoPage::whereNull('performance_score')->count();

        $recentAudits = SeoAuditLog::with('seoPage')
            ->latest()
            ->take(5)
            ->get();

        // Chart Data
        $chartData = SeoAuditLog::latest()
            ->take(10)
            ->get()
            ->reverse();

        $chartLabels = $chartData
            ->pluck('created_at')
            ->map(function ($date) {
                return $date->format('d M');
            });

        $chartScores = $chartData->pluck('score');

        return view('dashboard', compact(
            'totalPages',
            'totalAudits',
            'averageScore',
            'bestScore',
            'pagesWithoutAudit',
            'recentAudits',
            'chartLabels',
            'chartScores'
        ));
    }
}