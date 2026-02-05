@extends('layouts.app')

@section('title', $seoPage->page_title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">
                    <i class="fas fa-file-alt"></i> SEO Page Details
                </h4>
                <div class="btn-group">
                    <a href="{{ route('seo-pages.edit', $seoPage->id) }}" 
                       class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <form action="{{ route('seo-pages.audit', $seoPage->id) }}" 
                          method="POST" 
                          class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm ms-1">
                            <i class="fas fa-search"></i> Run Audit
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 30%">Page URL</th>
                        <td>
                            <a href="{{ $seoPage->page_url }}" target="_blank">
                                {{ $seoPage->page_url }}
                                <i class="fas fa-external-link-alt ms-1"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Page Title</th>
                        <td>{{ $seoPage->page_title }}</td>
                    </tr>
                    <tr>
                        <th>Meta Description</th>
                        <td>{{ $seoPage->meta_description }}</td>
                    </tr>
                    <tr>
                        <th>Meta Keywords</th>
                        <td>{{ $seoPage->meta_keywords ?? 'Not set' }}</td>
                    </tr>
                    <tr>
                        <th>Canonical URL</th>
                        <td>{{ $seoPage->canonical_url ?? 'Not set' }}</td>
                    </tr>
                    <tr>
                        <th>OG Title</th>
                        <td>{{ $seoPage->og_title ?? 'Not set' }}</td>
                    </tr>
                    <tr>
                        <th>OG Description</th>
                        <td>{{ $seoPage->og_description ?? 'Not set' }}</td>
                    </tr>
                    <tr>
                        <th>OG Image</th>
                        <td>
                            @if($seoPage->og_image)
                                <a href="{{ $seoPage->og_image }}" target="_blank">
                                    {{ $seoPage->og_image }}
                                </a>
                            @else
                                Not set
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td>{{ $seoPage->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated</th>
                        <td>{{ $seoPage->updated_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        @if($latestAudit)
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar"></i> Latest Audit Results
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center mb-4">
                    <div class="col-md-12">
                        <div class="display-4 fw-bold 
                            {{ $latestAudit->score >= 80 ? 'text-success' : 
                               ($latestAudit->score >= 60 ? 'text-warning' : 'text-danger') }}">
                            {{ $latestAudit->score }}/100
                        </div>
                        <p class="text-muted">Overall SEO Score</p>
                    </div>
                </div>
                
                <h6>Recommendations:</h6>
                <div class="alert alert-info">
                    {!! nl2br(e($latestAudit->recommendations)) !!}
                </div>
                
                <a href="{{ route('seo-pages.history', $seoPage->id) }}" 
                   class="btn btn-outline-primary">
                    <i class="fas fa-history"></i> View Audit History
                </a>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie"></i> SEO Metrics
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Performance Score
                        <span class="badge bg-{{ $seoPage->performance_score >= 80 ? 'success' : ($seoPage->performance_score >= 60 ? 'warning' : 'danger') }} rounded-pill">
                            {{ $seoPage->performance_score ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Word Count
                        <span class="badge bg-info rounded-pill">
                            {{ $seoPage->word_count ?? '0' }}
                        </span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Image Count
                        <span class="badge bg-info rounded-pill">
                            {{ $seoPage->image_count ?? '0' }}
                        </span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        Internal Links
                        <span class="badge bg-info rounded-pill">
                            {{ $seoPage->internal_links ?? '0' }}
                        </span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        External Links
                        <span class="badge bg-info rounded-pill">
                            {{ $seoPage->external_links ?? '0' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tools"></i> Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <form action="{{ route('seo-pages.audit', $seoPage->id) }}" 
                          method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary mb-2">
                            <i class="fas fa-search"></i> Run SEO Audit
                        </button>
                    </form>
                    
                    <a href="{{ route('seo-pages.history', $seoPage->id) }}" 
                       class="btn btn-info mb-2">
                        <i class="fas fa-history"></i> View Audit History
                    </a>
                    
                    <a href="{{ route('seo-pages.edit', $seoPage->id) }}" 
                       class="btn btn-warning mb-2">
                        <i class="fas fa-edit"></i> Edit Page
                    </a>
                    
                    <form action="{{ route('seo-pages.destroy', $seoPage->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this page?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash"></i> Delete Page
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection