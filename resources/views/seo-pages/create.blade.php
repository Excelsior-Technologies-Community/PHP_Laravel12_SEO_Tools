@extends('layouts.app')

@section('title', 'Add New SEO Page')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    <i class="fas fa-plus"></i> Add New SEO Page
                </h4>
            </div>
            <div class="card-body">
                <form action="{{ route('seo-pages.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="page_url" class="form-label">
                            <i class="fas fa-link"></i> Page URL *
                        </label>
                        <input type="url" 
                               class="form-control @error('page_url') is-invalid @enderror" 
                               id="page_url" 
                               name="page_url" 
                               value="{{ old('page_url') }}"
                               required>
                        <div class="form-text">Enter the full URL of the page</div>
                        @error('page_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="page_title" class="form-label">
                            <i class="fas fa-heading"></i> Page Title *
                        </label>
                        <input type="text" 
                               class="form-control @error('page_title') is-invalid @enderror" 
                               id="page_title" 
                               name="page_title" 
                               value="{{ old('page_title') }}"
                               maxlength="60"
                               required>
                        <div class="form-text">
                            <span id="title-counter">0/60</span> characters (Optimal: 50-60)
                        </div>
                        @error('page_title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">
                            <i class="fas fa-align-left"></i> Meta Description *
                        </label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                  id="meta_description" 
                                  name="meta_description" 
                                  rows="3"
                                  maxlength="160"
                                  required>{{ old('meta_description') }}</textarea>
                        <div class="form-text">
                            <span id="desc-counter">0/160</span> characters (Optimal: 120-160)
                        </div>
                        @error('meta_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">
                                    <i class="fas fa-key"></i> Meta Keywords
                                </label>
                                <input type="text" 
                                       class="form-control @error('meta_keywords') is-invalid @enderror" 
                                       id="meta_keywords" 
                                       name="meta_keywords" 
                                       value="{{ old('meta_keywords') }}">
                                <div class="form-text">Comma-separated keywords</div>
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="canonical_url" class="form-label">
                                    <i class="fas fa-exchange-alt"></i> Canonical URL
                                </label>
                                <input type="url" 
                                       class="form-control @error('canonical_url') is-invalid @enderror" 
                                       id="canonical_url" 
                                       name="canonical_url" 
                                       value="{{ old('canonical_url') }}">
                                @error('canonical_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">
                                <i class="fab fa-facebook"></i> Open Graph Tags (Optional)
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="og_title" class="form-label">OG Title</label>
                                <input type="text" 
                                       class="form-control @error('og_title') is-invalid @enderror" 
                                       id="og_title" 
                                       name="og_title" 
                                       value="{{ old('og_title') }}"
                                       maxlength="60">
                                <div class="form-text">Optimal: 60 characters</div>
                                @error('og_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="og_description" class="form-label">OG Description</label>
                                <textarea class="form-control @error('og_description') is-invalid @enderror" 
                                          id="og_description" 
                                          name="og_description" 
                                          rows="2"
                                          maxlength="160">{{ old('og_description') }}</textarea>
                                <div class="form-text">Optimal: 160 characters</div>
                                @error('og_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="og_image" class="form-label">OG Image URL</label>
                                <input type="url" 
                                       class="form-control @error('og_image') is-invalid @enderror" 
                                       id="og_image" 
                                       name="og_image" 
                                       value="{{ old('og_image') }}">
                                <div class="form-text">Recommended: 1200x630px</div>
                                @error('og_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('seo-pages.index') }}" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save SEO Page
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
    
    titleInput.addEventListener('input', function() {
        titleCounter.textContent = this.value.length + '/60';
    });
    titleCounter.textContent = titleInput.value.length + '/60';
    
    // Description character counter
    const descInput = document.getElementById('meta_description');
    const descCounter = document.getElementById('desc-counter');
    
    descInput.addEventListener('input', function() {
        descCounter.textContent = this.value.length + '/160';
    });
    descCounter.textContent = descInput.value.length + '/160';
});
</script>
@endpush