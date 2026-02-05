@extends('layouts.app')

@section('title', 'Audit History - ' . $seoPage->page_title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-history"></i> Audit History: 
        <small class="text-muted">{{ Str::limit($seoPage->page_title, 40) }}</small>
    </h1>
    <a href="{{ route('seo-pages.show', $seoPage->id) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back to Page
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($seoPage->auditLogs->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Audit Date</th>
                            <th>Type</th>
                            <th>Score</th>
                            <th>Issues Found</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seoPage->auditLogs->sortByDesc('created_at') as $audit)
                        <tr>
                            <td>{{ $audit->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ ucfirst(str_replace('_', ' ', $audit->audit_type)) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $audit->score >= 80 ? 'success' : ($audit->score >= 60 ? 'warning' : 'danger') }}">
                                    {{ $audit->score }}/100
                                </span>
                            </td>
                            <td>
                                @php
                                    $issues = collect($audit->audit_data)->flatMap(function ($section) {
                                        return $section['issues'] ?? [];
                                    })->count();
                                @endphp
                                {{ $issues }} issues
                            </td>
                            <td>
                                <button type="button" 
                                        class="btn btn-sm btn-info" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#auditModal{{ $audit->id }}">
                                    <i class="fas fa-eye"></i> Details
                                </button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="auditModal{{ $audit->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Audit Details - {{ $audit->created_at->format('Y-m-d H:i:s') }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <div class="card text-center">
                                                    <div class="card-body">
                                                        <h2 class="{{ $audit->score >= 80 ? 'text-success' : ($audit->score >= 60 ? 'text-warning' : 'text-danger') }}">
                                                            {{ $audit->score }}
                                                        </h2>
                                                        <p class="text-muted mb-0">Overall Score</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <h6>Recommendations:</h6>
                                                <div class="alert alert-info">
                                                    {!! nl2br(e($audit->recommendations)) !!}
                                                </div>
                                            </div>
                                        </div>

                                        @foreach($audit->audit_data as $section => $data)
                                            <div class="card mb-3">
                                                <div class="card-header">
                                                    <h6 class="mb-0">
                                                        {{ ucfirst(str_replace('_', ' ', $section)) }}
                                                        <span class="badge bg-{{ $data['score'] >= 80 ? 'success' : ($data['score'] >= 60 ? 'warning' : 'danger') }} float-end">
                                                            {{ $data['score'] }}/100
                                                        </span>
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    @if(!empty($data['passed']))
                                                        <h6>Passed Checks:</h6>
                                                        <ul class="list-unstyled">
                                                            @foreach($data['passed'] as $passed)
                                                                <li class="text-success">
                                                                    <i class="fas fa-check-circle"></i> {{ $passed }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif

                                                    @if(!empty($data['issues']))
                                                        <h6>Issues:</h6>
                                                        <ul class="list-unstyled">
                                                            @foreach($data['issues'] as $issue)
                                                                <li class="text-danger">
                                                                    <i class="fas fa-exclamation-circle"></i> {{ $issue }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <h4>No audit history found</h4>
                <p>Run your first SEO audit to see results here.</p>
                <form action="{{ route('seo-pages.audit', $seoPage->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Run First Audit
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection