@extends('layouts.app')

@section('title', 'SEO Tools - Home')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="display-4 mb-4">
                <i class="fas fa-chart-line text-primary"></i>
                Laravel SEO Tools
            </h1>
            
            <p class="lead mb-4">
                A comprehensive SEO management tool built with Laravel 12. 
                Analyze, optimize, and track your website's SEO performance.
            </p>
            
            <div class="row mt-5">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-search fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">SEO Audit</h5>
                            <p class="card-text">
                                Run comprehensive SEO audits on your pages and get actionable recommendations.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-sitemap fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Sitemap Generator</h5>
                            <p class="card-text">
                                Generate and manage XML sitemaps for better search engine crawling.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-chart-bar fa-3x text-info mb-3"></i>
                            <h5 class="card-title">Performance Tracking</h5>
                            <p class="card-text">
                                Track SEO performance over time with detailed analytics and reports.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-5">
                <h3 class="mb-4">Get Started</h3>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-tachometer-alt"></i> Go to Dashboard
                    </a>
                    <a href="{{ route('seo-pages.create') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-plus"></i> Add First Page
                    </a>
                </div>
            </div>
            
            <div class="mt-5">
                <h4>Features</h4>
                <div class="row text-start mt-3">
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Meta Tag Analysis</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Content Optimization</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Performance Scoring</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Sitemap Generation</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Robots.txt Management</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Audit History</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection