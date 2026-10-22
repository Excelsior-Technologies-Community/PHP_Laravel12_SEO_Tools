@extends('layouts.app')

@section('title', 'Add New SEO Page')

@section('content')
<div class="row">
    <div class="col-md-9 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0 fw-bold text-primary">
                    <i class="fas fa-plus-circle me-1"></i> Add New SEO Page
                </h4>
                <a href="{{ route('seo-pages.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Index
                </a>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('seo-pages.store') }}" method="POST">
                    @csrf
                    
                    {{-- Target URL --}}
                    <div class="mb-3">
                        <label for="page_url" class="form-label fw-bold">
                            <i class="fas fa-link text-primary me-1"></i> Page Target URL *
                        </label>
                        <input type="url" 
                               class="form-control @error('page_url') is-invalid @enderror" 
                               id="page_url" 
                               name="page_url" 
                               value="{{ old('page_url') }}"
                               placeholder="https://example.com/about-us"
                               required>
                        <div class="form-text">Enter the full target URL including http:// or https://</div>
                        @error('page_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Page Title --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="page_title" class="form-label fw-bold mb-0">
                                <i class="fas fa-heading text-primary me-1"></i> Page Title (&lt;title&gt;) *
                            </label>
                            <span class="badge bg-light text-dark border" id="title-counter">
                                {{ strlen(old('page_title', '')) }}/60 chars
                            </span>
                        </div>
                        <input type="text" 
                               class="form-control @error('page_title') is-invalid @enderror" 
                               id="page_title" 
                               name="page_title" 
                               value="{{ old('page_title') }}"
                               maxlength="255"
                               placeholder="Optimal: 50-60 characters for search engines"
                               required>
                        <div class="form-text">Optimal title length is 50–60 characters to avoid snippet truncation.</div>
                        @error('page_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Main H1 Heading --}}
                    <div class="mb-3">
                        <label for="h1_tag" class="form-label fw-bold">
                            <i class="fas fa-font text-primary me-1"></i> Main H1 Heading
                        </label>
                        <input type="text" 
                               class="form-control @error('h1_tag') is-invalid @enderror" 
                               id="h1_tag" 
                               name="h1_tag" 
                               value="{{ old('h1_tag') }}"
                               maxlength="255"
                               placeholder="e.g., Welcome to Our SEO Optimization Platform">
                        <div class="form-text">Recommended: Exactly 1 primary H1 heading per page.</div>
                        @error('h1_tag')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Meta Description --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="meta_description" class="form-label fw-bold mb-0">
                                <i class="fas fa-align-left text-primary me-1"></i> Meta Description *
                            </label>
                            <span class="badge bg-light text-dark border" id="desc-counter">
                                {{ strlen(old('meta_description', '')) }}/160 chars
                            </span>
                        </div>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                  id="meta_description" 
                                  name="meta_description" 
                                  rows="3"
                                  maxlength="500"
                                  placeholder="Optimal: 120-160 characters describing the purpose of the page..."
                                  required>{{ old('meta_description') }}</textarea>
                        <div class="form-text">Optimal description length is 120–160 characters for rich snippets.</div>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Keywords & Canonical --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label fw-bold">
                                    <i class="fas fa-key text-primary me-1"></i> Meta Keywords
                                </label>
                                <input type="text" 
                                       class="form-control @error('meta_keywords') is-invalid @enderror" 
                                       id="meta_keywords" 
                                       name="meta_keywords" 
                                       value="{{ old('meta_keywords') }}"
                                       placeholder="laravel, seo tools, analytics">
                                <div class="form-text">Comma-separated keywords (optional).</div>
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="canonical_url" class="form-label fw-bold">
                                    <i class="fas fa-exchange-alt text-primary me-1"></i> Canonical URL
                                </label>
                                <input type="text" 
                                       class="form-control @error('canonical_url') is-invalid @enderror" 
                                       id="canonical_url" 
                                       name="canonical_url" 
                                       value="{{ old('canonical_url') }}"
                                       placeholder="https://example.com/canonical-source">
                                <div class="form-text">Preferred authoritative URL (optional).</div>
                                @error('canonical_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    {{-- Open Graph & Social Sharing --}}
                    <div class="card mb-3 border bg-light bg-opacity-25">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold text-dark">
                                <i class="fab fa-facebook text-primary me-1"></i> Open Graph & Social Card Tags (Optional)
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="og_title" class="form-label fw-bold small">OG Title</label>
                                <input type="text" 
                                       class="form-control @error('og_title') is-invalid @enderror" 
                                       id="og_title" 
                                       name="og_title" 
                                       value="{{ old('og_title') }}"
                                       maxlength="255"
                                       placeholder="Social title card headline...">
                                @error('og_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="og_description" class="form-label fw-bold small">OG Description</label>
                                <textarea class="form-control @error('og_description') is-invalid @enderror" 
                                          id="og_description" 
                                          name="og_description" 
                                          rows="2"
                                          maxlength="500"
                                          placeholder="Social snippet description...">{{ old('og_description') }}</textarea>
                                @error('og_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="og_image" class="form-label fw-bold small">OG Image URL</label>
                                <input type="text" 
                                       class="form-control @error('og_image') is-invalid @enderror" 
                                       id="og_image" 
                                       name="og_image" 
                                       value="{{ old('og_image') }}"
                                       placeholder="https://example.com/images/share-preview.png">
                                <div class="form-text">Recommended preview dimensions: 1200x630px.</div>
                                @error('og_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Content & Link Metrics --}}
                    <div class="card mb-4 border bg-light bg-opacity-25">
                        <div class="card-header bg-light">
                            <h6 class="mb-0 fw-bold text-dark">
                                <i class="fas fa-chart-bar text-primary me-1"></i> Content & Link Metrics (Optional)
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3 col-6">
                                    <label for="word_count" class="form-label small fw-bold">Word Count</label>
                                    <input type="number" min="0" class="form-control @error('word_count') is-invalid @enderror" id="word_count" name="word_count" value="{{ old('word_count', 0) }}">
                                    @error('word_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-3 col-6">
                                    <label for="image_count" class="form-label small fw-bold">Image Count</label>
                                    <input type="number" min="0" class="form-control @error('image_count') is-invalid @enderror" id="image_count" name="image_count" value="{{ old('image_count', 0) }}">
                                    @error('image_count')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-3 col-6">
                                    <label for="internal_links" class="form-label small fw-bold">Internal Links</label>
                                    <input type="number" min="0" class="form-control @error('internal_links') is-invalid @enderror" id="internal_links" name="internal_links" value="{{ old('internal_links', 0) }}">
                                    @error('internal_links')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-3 col-6">
                                    <label for="external_links" class="form-label small fw-bold">External Links</label>
                                    <input type="number" min="0" class="form-control @error('external_links') is-invalid @enderror" id="external_links" name="external_links" value="{{ old('external_links', 0) }}">
                                    @error('external_links')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Form Actions --}}
                    <div class="d-flex justify-content-between align-items-center pt-2">
                        <a href="{{ route('seo-pages.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="fas fa-save me-1"></i> Save SEO Page
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Title character counter
    const titleInput = document.getElementById('page_title');
    const titleCounter = document.getElementById('title-counter');
    
    function updateTitleCounter() {
        if (!titleInput || !titleCounter) return;
        const len = titleInput.value.length;
        titleCounter.textContent = len + '/60 chars';
        if (len >= 50 && len <= 60) {
            titleCounter.className = 'badge bg-success text-white';
        } else if (len > 60) {
            titleCounter.className = 'badge bg-warning text-dark';
        } else {
            titleCounter.className = 'badge bg-light text-dark border';
        }
    }
    
    titleInput.addEventListener('input', updateTitleCounter);
    updateTitleCounter();
    
    // Description character counter
    const descInput = document.getElementById('meta_description');
    const descCounter = document.getElementById('desc-counter');
    
    function updateDescCounter() {
        if (!descInput || !descCounter) return;
        const len = descInput.value.length;
        descCounter.textContent = len + '/160 chars';
        if (len >= 120 && len <= 160) {
            descCounter.className = 'badge bg-success text-white';
        } else if (len > 160) {
            descCounter.className = 'badge bg-warning text-dark';
        } else {
            descCounter.className = 'badge bg-light text-dark border';
        }
    }
    
    descInput.addEventListener('input', updateDescCounter);
    updateDescCounter();
});
</script>
@endpush
