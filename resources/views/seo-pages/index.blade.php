@extends('layouts.app')

@section('title', 'SEO Pages')

@section('content')

<div class="container-fluid px-0">

    {{-- Top Title & Actions Bar --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-search-plus text-primary me-2"></i> SEO Pages & Live Crawl Hub
            </h2>
            <p class="text-muted small mb-0">Inspect on-page tags, Core Web Vitals, SERP simulations, and link topology.</p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <form action="{{ route('seo-pages.bulk-audit') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Run comprehensive SEO audit for every page?')">
                    <i class="fas fa-bolt me-1"></i> Bulk Audit
                </button>
            </form>

            <a href="{{ route('seo-pages.export') }}" class="btn btn-outline-success">
                <i class="fas fa-file-csv me-1"></i> Export CSV
            </a>

            <a href="{{ route('seo-pages.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add Manual Page
            </a>
        </div>
    </div>

    {{-- Feature 1: Live Real-Time Website Crawler & URL DOM Inspector Bar --}}
    <div class="card shadow-sm border-0 mb-4 rounded-3 overflow-hidden" style="background: linear-gradient(135deg, #1e293b, #0f172a); color: white;">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 text-info text-uppercase fw-bold" style="font-size: 11px; letter-spacing: 1px;">
                        <span class="spinner-grow spinner-grow-sm text-info" role="status"></span>
                        Live Web Crawler & DOM Inspector
                    </div>
                    <h5 class="fw-bold text-white mb-1 mt-1">Crawl Any Live Website URL</h5>
                    <p class="text-white-50 small mb-0">Instantly extracts on-page tags, Core Web Vitals, H1-H6 tree, and image ALT tags.</p>
                </div>

                <div class="col-lg-8">
                    <form id="liveCrawlForm" onsubmit="event.preventDefault(); triggerLiveCrawl();">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-white border-0 text-muted">
                                <i class="fas fa-globe"></i>
                            </span>
                            <input type="url" id="liveCrawlUrl" class="form-control border-0" placeholder="https://laravel.com/docs or any live URL..." required>
                            <button type="submit" class="btn btn-primary px-4 fw-bold" id="btnLiveCrawl">
                                <i class="fas fa-spider me-1"></i> Crawl & Inspect
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Filter Card --}}
    <div class="card shadow-sm border-0 mb-4 rounded-3">
        <div class="card-body p-3">
            <form action="{{ route('seo-pages.index') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0" placeholder="Search URL, Page Title, or Description...">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <select name="score" class="form-select">
                            <option value="">All Health Scores</option>
                            <option value="excellent" {{ request('score')=='excellent' ? 'selected' : '' }}>Excellent (80+)</option>
                            <option value="good" {{ request('score')=='good' ? 'selected' : '' }}>Good (60-79)</option>
                            <option value="poor" {{ request('score')=='poor' ? 'selected' : '' }}>Poor (Below 60)</option>
                            <option value="not_audited" {{ request('score')=='not_audited' ? 'selected' : '' }}>Not Audited</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-secondary w-50">Filter</button>
                        <a href="{{ route('seo-pages.index') }}" class="btn btn-outline-secondary w-50">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- SEO Pages Table --}}
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold mb-0">Managed Pages ({{ $pages->total() }})</h5>
            <span class="text-muted small">Showing {{ $pages->firstItem() ?? 0 }} - {{ $pages->lastItem() ?? 0 }} of {{ $pages->total() }}</span>
        </div>

        <div class="card-body p-0">
            @if($pages->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Page Details</th>
                            <th>Health Grade</th>
                            <th>TTFB / Speed</th>
                            <th>Word Count</th>
                            <th>Image Alt Deficits</th>
                            <th>Last Audited</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pages as $page)
                        @php $grade = $page->health_grade; @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark text-truncate" style="max-width: 320px;">
                                    <a href="{{ route('seo-pages.show', $page->id) }}" class="text-decoration-none text-dark hover-primary">
                                        {{ $page->page_title }}
                                    </a>
                                </div>
                                <div class="small text-muted text-truncate font-monospace" style="max-width: 320px;">
                                    <a href="{{ $page->page_url }}" target="_blank" class="text-muted text-decoration-none">
                                        {{ $page->page_url }} <i class="fas fa-external-link-alt" style="font-size: 10px;"></i>
                                    </a>
                                </div>
                            </td>

                            <td>
                                @if(is_null($page->performance_score))
                                <span class="badge bg-secondary">Not Audited</span>
                                @else
                                <span class="badge bg-{{ $grade['color'] }} px-2 py-1">
                                    Grade {{ $grade['grade'] }} ({{ round($page->performance_score) }}/100)
                                </span>
                                @endif
                            </td>

                            <td>
                                <span class="small font-monospace fw-bold text-dark">
                                    {{ $page->ttfb_ms ? $page->ttfb_ms . ' ms' : '~120 ms' }}
                                </span>
                            </td>

                            <td>
                                <span class="small text-muted">
                                    {{ number_format($page->word_count ?? 0) }} words
                                </span>
                            </td>

                            <td>
                                @if(($page->images_missing_alt ?? 0) > 0)
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">
                                    ⚠️ {{ $page->images_missing_alt }} Missing
                                </span>
                                @else
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                                    ✓ All Tagged
                                </span>
                                @endif
                            </td>

                            <td class="small text-muted">
                                {{ $page->updated_at->diffForHumans() }}
                            </td>

                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('seo-pages.report', $page->id) }}" target="_blank" class="btn btn-outline-primary" title="Print Executive Report Card">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('seo-pages.show', $page->id) }}" class="btn btn-outline-info" title="View Studio">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('seo-pages.edit', $page->id) }}" class="btn btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('seo-pages.destroy', $page->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this page?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
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

            <div class="p-3 border-top">
                {{ $pages->links() }}
            </div>
            @else
            <div class="p-5 text-center text-muted">
                <i class="fas fa-search fa-3x mb-3 text-secondary opacity-50"></i>
                <h5>No SEO Pages Found</h5>
                <p class="small">Use the Live Crawler bar above to automatically inspect and import any URL.</p>
            </div>
            @endif
        </div>
    </div>

</div>

{{-- Live Crawl Inspection Result Modal --}}
<div class="modal fade" id="liveCrawlResultModal" tabindex="-1" aria-labelledby="liveCrawlModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold" id="liveCrawlModalLabel">
                    <i class="fas fa-spider me-2"></i> Live URL Inspection Complete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="liveCrawlModalBody">
                {{-- Populated dynamically by JS --}}
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btnSaveCrawledPage" onclick="saveAndRedirectCrawledPage()">
                    <i class="fas fa-save me-1"></i> Save to Managed Pages & View
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let lastCrawledData = null;

    function triggerLiveCrawl() {
        const url = document.getElementById('liveCrawlUrl').value;
        const btn = document.getElementById('btnLiveCrawl');

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Crawling...';

        fetch("{{ route('seo-pages.crawl') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ url: url, save: 0 })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-spider me-1"></i> Crawl & Inspect';

            if (data.success) {
                lastCrawledData = data.data;
                const d = data.data;

                const bodyHtml = `
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-primary fs-6">Score: ${d.performance_score}/100</span>
                        <span class="text-muted small">Response: <strong>${d.http_status} OK</strong> • TTFB: <strong>${d.ttfb_ms}ms</strong></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase mb-0">Title Tag</label>
                        <div class="p-2 bg-light rounded fw-bold text-dark">${d.page_title || '[Missing Title]'}</div>
                        <div class="small text-muted mt-1">${(d.page_title || '').length} characters</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-muted text-uppercase mb-0">Meta Description</label>
                        <div class="p-2 bg-light rounded text-secondary small">${d.meta_description || '[Missing Description]'}</div>
                        <div class="small text-muted mt-1">${(d.meta_description || '').length} characters</div>
                    </div>

                    <div class="row g-2 text-center mb-3">
                        <div class="col-3 p-2 bg-light rounded border">
                            <div class="small text-muted">Word Count</div>
                            <div class="fw-bold fs-6">${d.word_count}</div>
                        </div>
                        <div class="col-3 p-2 bg-light rounded border">
                            <div class="small text-muted">Images</div>
                            <div class="fw-bold fs-6">${d.image_count}</div>
                        </div>
                        <div class="col-3 p-2 bg-light rounded border">
                            <div class="small text-muted">Missing Alt</div>
                            <div class="fw-bold fs-6 text-danger">${d.images_missing_alt}</div>
                        </div>
                        <div class="col-3 p-2 bg-light rounded border">
                            <div class="small text-muted">Internal Links</div>
                            <div class="fw-bold fs-6">${d.internal_links}</div>
                        </div>
                    </div>
                `;

                document.getElementById('liveCrawlModalBody').innerHTML = bodyHtml;
                const modal = new bootstrap.Modal(document.getElementById('liveCrawlResultModal'));
                modal.show();
            } else {
                alert('Could not inspect URL. Please ensure domain is accessible.');
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-spider me-1"></i> Crawl & Inspect';
            alert('Live crawler request failed.');
        });
    }

    function saveAndRedirectCrawledPage() {
        if (!lastCrawledData) return;
        const btn = document.getElementById('btnSaveCrawledPage');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

        fetch("{{ route('seo-pages.crawl') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ url: lastCrawledData.url, save: 1 })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.page_id) {
                window.location.href = `/seo-pages/${data.page_id}`;
            } else {
                window.location.reload();
            }
        })
        .catch(() => window.location.reload());
    }
</script>

@endsection
