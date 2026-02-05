@extends('layouts.app')

@section('title', 'SEO Pages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-file-alt"></i> SEO Pages</h1>
    <a href="{{ route('seo-pages.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Page
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($pages->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Page URL</th>
                            <th>Title</th>
                            <th>SEO Score</th>
                            <th>Last Audit</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                        <tr>
                            <td>
                                <a href="{{ $page->page_url }}" target="_blank" class="text-decoration-none">
                                    {{ Str::limit($page->page_url, 40) }}
                                    <i class="fas fa-external-link-alt ms-1"></i>
                                </a>
                            </td>
                            <td>{{ Str::limit($page->page_title, 50) }}</td>
                            <td>
                                @if($page->performance_score)
                                    <span class="badge bg-{{ $page->performance_score >= 80 ? 'success' : ($page->performance_score >= 60 ? 'warning' : 'danger') }}">
                                        {{ $page->performance_score }}/100
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Not Audited</span>
                                @endif
                            </td>
                            <td>
                                @if($page->auditLogs->count() > 0)
                                    {{ $page->auditLogs->first()->created_at->diffForHumans() }}
                                @else
                                    Never
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('seo-pages.show', $page->id) }}" 
                                       class="btn btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('seo-pages.edit', $page->id) }}" 
                                       class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('seo-pages.destroy', $page->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                {{ $pages->links() }}
            </div>
        @else
            <div class="alert alert-info">
                No SEO pages found. <a href="{{ route('seo-pages.create') }}">Create your first page</a>.
            </div>
        @endif
    </div>
</div>
@endsection