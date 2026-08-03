@extends('layouts.app')

@section('title', 'SEO Tools Dashboard')

@push('styles')
<style>
    body {
        background: #f4f7fb;
    }

    .dashboard-title {
        font-weight: 700;
        color: #1f2937;
    }

    .dashboard-card {
        border: none;
        border-radius: 18px;
        overflow: hidden;
        transition: .35s;
        position: relative;
        color: #fff;
    }

    .dashboard-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 35px rgba(0, 0, 0, .18);
    }

    .dashboard-card .card-body {
        padding: 25px;
    }

    .dashboard-card h6 {
        font-size: 15px;
        font-weight: 600;
        opacity: .9;
    }

    .dashboard-card h2 {
        font-size: 34px;
        font-weight: 700;
        margin-top: 10px;
    }

    .dashboard-icon {
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 48px;
        opacity: .18;
    }

    .bg-blue {
        background: linear-gradient(135deg, #0d6efd, #4f8cff);
    }

    .bg-green {
        background: linear-gradient(135deg, #198754, #38c172);
    }

    .bg-cyan {
        background: linear-gradient(135deg, #0dcaf0, #5ddcff);
    }

    .bg-orange {
        background: linear-gradient(135deg, #ff9800, #ffc107);
    }

    .bg-red {
        background: linear-gradient(135deg, #dc3545, #ff6b81);
    }

    .section-title {
        font-weight: 600;
    }
</style>
@endpush

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="dashboard-title">

                <i class="fas fa-chart-line text-primary me-2"></i>

                SEO Tools Dashboard

            </h2>

            <p class="text-muted mb-0">

                Monitor your SEO performance and website optimization.

            </p>

        </div>

    </div>

    <div class="row g-4">

        <div class="col-lg col-md-6">

            <div class="card dashboard-card bg-blue shadow">

                <div class="card-body">

                    <i class="fas fa-file-alt dashboard-icon"></i>

                    <h6>Total Pages</h6>

                    <h2>{{ $totalPages }}</h2>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6">

            <div class="card dashboard-card bg-green shadow">

                <div class="card-body">

                    <i class="fas fa-search dashboard-icon"></i>

                    <h6>Total Audits</h6>

                    <h2>{{ $totalAudits }}</h2>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6">

            <div class="card dashboard-card bg-cyan shadow">

                <div class="card-body">

                    <i class="fas fa-chart-bar dashboard-icon"></i>

                    <h6>Average Score</h6>

                    <h2>{{ number_format($averageScore,1) }}</h2>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6">

            <div class="card dashboard-card bg-orange shadow">

                <div class="card-body">

                    <i class="fas fa-trophy dashboard-icon"></i>

                    <h6>Best Score</h6>

                    <h2>{{ $bestScore }}/100</h2>

                </div>

            </div>

        </div>

        <div class="col-lg col-md-6">

            <div class="card dashboard-card bg-red shadow">

                <div class="card-body">

                    <i class="fas fa-times-circle dashboard-icon"></i>

                    <h6>Pages Without Audit</h6>

                    <h2>{{ $pagesWithoutAudit }}</h2>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-5">

        <div class="col-lg-6 mb-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

                <div class="card-header bg-primary text-white rounded-top-4">

                    <h5 class="mb-0">

                        <i class="fas fa-bolt me-2"></i>

                        Quick Actions

                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-grid gap-3">

                        <a href="{{ route('seo-pages.create') }}"
                            class="btn btn-primary btn-lg">

                            <i class="fas fa-plus-circle me-2"></i>

                            Add New SEO Page

                        </a>

                        <a href="{{ route('sitemap.generate') }}"
                            class="btn btn-success btn-lg">

                            <i class="fas fa-sitemap me-2"></i>

                            Generate Sitemap

                        </a>

                        <a href="{{ route('robots.generate') }}"
                            class="btn btn-warning btn-lg">

                            <i class="fas fa-robot me-2"></i>

                            Generate Robots.txt

                        </a>

                        <a href="{{ route('seo-pages.index') }}"
                            class="btn btn-info btn-lg text-white">

                            <i class="fas fa-list me-2"></i>

                            Manage SEO Pages

                        </a>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-6 mb-4">

            <div class="card shadow-lg border-0 rounded-4 h-100">

                <div class="card-header bg-success text-white rounded-top-4">

                    <h5 class="mb-0">

                        <i class="fas fa-lightbulb me-2"></i>

                        SEO Best Practices

                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <div class="d-flex align-items-start">

                            <i class="fas fa-check-circle text-success mt-1 me-3"></i>

                            <div>

                                <strong>Title Tag</strong>

                                <p class="text-muted mb-0">

                                    Keep page titles between 50 and 60 characters.

                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="mb-3">

                        <div class="d-flex align-items-start">

                            <i class="fas fa-check-circle text-success mt-1 me-3"></i>

                            <div>

                                <strong>Meta Description</strong>

                                <p class="text-muted mb-0">

                                    Write engaging descriptions between 120 and 160 characters.

                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="mb-3">

                        <div class="d-flex align-items-start">

                            <i class="fas fa-check-circle text-success mt-1 me-3"></i>

                            <div>

                                <strong>Heading Structure</strong>

                                <p class="text-muted mb-0">

                                    Use one H1 and organize content with H2 and H3 headings.

                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="mb-3">

                        <div class="d-flex align-items-start">

                            <i class="fas fa-check-circle text-success mt-1 me-3"></i>

                            <div>

                                <strong>Images</strong>

                                <p class="text-muted mb-0">

                                    Optimize images and always provide descriptive ALT text.

                                </p>

                            </div>

                        </div>

                    </div>

                    <div>

                        <div class="d-flex align-items-start">

                            <i class="fas fa-check-circle text-success mt-1 me-3"></i>

                            <div>

                                <strong>Content Quality</strong>

                                <p class="text-muted mb-0">

                                    Publish original, keyword-focused content with at least 300 words.

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-2">

        <div class="col-12">

            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-header bg-dark text-white">

                    <div class="d-flex justify-content-between align-items-center">

                        <h5 class="mb-0">

                            <i class="fas fa-history me-2"></i>

                            Recent SEO Audits

                        </h5>

                        <span class="badge bg-primary">

                            {{ $recentAudits->count() }} Recent Records

                        </span>

                    </div>

                </div>

                <div class="card-body">

                    @if($recentAudits->count() > 0)

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-primary">

                                <tr>

                                    <th>Page</th>

                                    <th>Date</th>

                                    <th>Score</th>

                                    <th>Audit Type</th>

                                    <th width="120">Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach($recentAudits as $audit)

                                <tr>

                                    <td>

                                        <strong>

                                            {{ \Illuminate\Support\Str::limit($audit->seoPage->page_title ?? 'N/A',40) }}

                                        </strong>

                                    </td>

                                    <td>

                                        {{ $audit->created_at->format('d M Y') }}

                                        <br>

                                        <small class="text-muted">

                                            {{ $audit->created_at->format('h:i A') }}

                                        </small>

                                    </td>

                                    <td>

                                        @if($audit->score >= 80)

                                        <span class="badge bg-success px-3 py-2">

                                            {{ $audit->score }}/100

                                        </span>

                                        @elseif($audit->score >= 60)

                                        <span class="badge bg-warning text-dark px-3 py-2">

                                            {{ $audit->score }}/100

                                        </span>

                                        @else

                                        <span class="badge bg-danger px-3 py-2">

                                            {{ $audit->score }}/100

                                        </span>

                                        @endif

                                    </td>

                                    <td>

                                        <span class="badge bg-info text-dark">

                                            {{ ucfirst(str_replace('_',' ',$audit->audit_type)) }}

                                        </span>

                                    </td>

                                    <td>

                                        <a href="{{ route('seo-pages.show',$audit->seoPage->id) }}"
                                            class="btn btn-sm btn-primary">

                                            <i class="fas fa-eye me-1"></i>

                                            View

                                        </a>

                                    </td>

                                </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                    @else

                    <div class="text-center py-5">

                        <i class="fas fa-search fa-4x text-secondary mb-3"></i>

                        <h4>No SEO Audits Found</h4>

                        <p class="text-muted">

                            Run your first SEO audit to see the latest results here.

                        </p>

                        <a href="{{ route('seo-pages.index') }}"
                            class="btn btn-primary">

                            <i class="fas fa-list me-2"></i>

                            Manage SEO Pages

                        </a>

                    </div>

                    @endif

                </div>

            </div>

        </div>

        @endsection