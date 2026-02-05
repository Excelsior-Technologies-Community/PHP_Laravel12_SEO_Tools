@extends('layouts.app')

@section('title', 'SEO Tools Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="mb-4"><i class="fas fa-tachometer-alt"></i> SEO Tools Dashboard</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Pages</h5>
                        <h2 class="mb-0">{{ $totalPages }}</h2>
                    </div>
                    <i class="fas fa-file-alt fa-3x"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Average SEO Score</h5>
                        <h2 class="mb-0">{{ number_format($averageScore, 1) }}/100</h2>
                    </div>
                    <i class="fas fa-chart-line fa-3x"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Quick Actions</h5>
                        <div class="mt-2">
                            <a href="{{ route('seo-pages.create') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-plus"></i> Add New Page
                            </a>
                            <a href="{{ route('sitemap.generate') }}" class="btn btn-light btn-sm mt-1">
                                <i class="fas fa-sitemap"></i> Generate Sitemap
                            </a>
                        </div>
                    </div>
                    <i class="fas fa-bolt fa-3x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent SEO Audits</h5>
            </div>
            <div class="card-body">
                @if($recentAudits->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Page</th>
                                    <th>Audit Date</th>
                                    <th>Score</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAudits as $audit)
                                <tr>
                                    <td>{{ Str::limit($audit->seoPage->page_title, 40) }}</td>
                                    <td>{{ $audit->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <span class="badge bg-{{ $audit->score >= 80 ? 'success' : ($audit->score >= 60 ? 'warning' : 'danger') }}">
                                            {{ $audit->score }}/100
                                        </span>
                                    </td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $audit->audit_type)) }}</td>
                                    <td>
                                        <a href="{{ route('seo-pages.show', $audit->seoPage->id) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        No audits found. Run your first SEO audit!
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">SEO Tools</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ route('sitemap.generate') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-sitemap me-2"></i> Generate Sitemap
                    </a>
                    <a href="{{ route('robots.generate') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-robot me-2"></i> Generate Robots.txt
                    </a>
                    <a href="{{ route('seo-pages.index') }}" class="list-group-item list-group-item-action">
                        <i class="fas fa-list me-2"></i> Manage SEO Pages
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">SEO Tips</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Keep titles under 60 characters</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Meta descriptions should be 120-160 characters</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Use only one H1 per page</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Add Open Graph tags for social media</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Aim for 300+ words of quality content</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection