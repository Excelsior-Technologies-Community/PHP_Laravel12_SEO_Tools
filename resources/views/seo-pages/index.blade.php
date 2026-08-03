@extends('layouts.app')

@section('title', 'SEO Pages')

@section('content')

<div class="container-fluid">

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}

        <button class="btn-close"
            data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="fas fa-search"></i>
            SEO Pages
        </h2>

        <div>

            <a href="{{ route('seo-pages.export') }}"
                class="btn btn-success">

                <i class="fas fa-file-csv"></i>

                Export CSV

            </a>

            <a href="{{ route('seo-pages.create') }}"
                class="btn btn-primary">

                <i class="fas fa-plus"></i>

                Add SEO Page

            </a>

        </div>

    </div>

    <div class="card shadow-sm mb-4">

        <div class="card-header bg-primary text-white">

            <strong>

                <i class="fas fa-filter"></i>

                Search & Filter

            </strong>

        </div>

        <div class="card-body">

            <form
                action="{{ route('seo-pages.index') }}"
                method="GET">

                <div class="row">

                    <div class="col-md-5 mb-3">

                        <label class="form-label">

                            Search

                        </label>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Search URL, Title or Description">

                    </div>

                    <div class="col-md-3 mb-3">

                        <label class="form-label">

                            SEO Score

                        </label>

                        <select
                            name="score"
                            class="form-select">

                            <option value="">

                                All

                            </option>

                            <option
                                value="excellent"
                                {{ request('score')=='excellent' ? 'selected' : '' }}>

                                Excellent (80+)

                            </option>

                            <option
                                value="good"
                                {{ request('score')=='good' ? 'selected' : '' }}>

                                Good (60-79)

                            </option>

                            <option
                                value="poor"
                                {{ request('score')=='poor' ? 'selected' : '' }}>

                                Poor (Below 60)

                            </option>

                            <option
                                value="not_audited"
                                {{ request('score')=='not_audited' ? 'selected' : '' }}>

                                Not Audited

                            </option>

                        </select>

                    </div>

                    <div
                        class="col-md-4 d-flex align-items-end mb-3">

                        <button
                            class="btn btn-primary me-2">

                            <i class="fas fa-search"></i>

                            Search

                        </button>

                        <a
                            href="{{ route('seo-pages.index') }}"
                            class="btn btn-secondary">

                            <i class="fas fa-sync"></i>

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <div class="card shadow">

        <div class="card-header">

            <div class="d-flex justify-content-between">

                <h5 class="mb-0">

                    SEO Pages List

                </h5>

                <span class="badge bg-primary">

                    Total :
                    {{ $pages->total() }}

                </span>

            </div>

        </div>

        <div class="card-body">

            @if($pages->count())

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th width="60">
                                #
                            </th>

                            <th>
                                URL
                            </th>

                            <th>
                                Title
                            </th>

                            <th width="130">
                                SEO Score
                            </th>

                            <th width="150">
                                Last Audit
                            </th>

                            <th width="200">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($pages as $page)

                        <tr>

                            <td>
                                {{ $loop->iteration + ($pages->firstItem() - 1) }}
                            </td>

                            <td>

                                <a href="{{ $page->page_url }}"
                                    target="_blank"
                                    class="text-decoration-none">

                                    {{ \Illuminate\Support\Str::limit($page->page_url,45) }}

                                    <i class="fas fa-external-link-alt ms-1"></i>

                                </a>

                            </td>

                            <td>

                                <strong>

                                    {{ \Illuminate\Support\Str::limit($page->page_title,50) }}

                                </strong>

                            </td>

                            <td>

                                @if(is_null($page->performance_score))

                                <span class="badge bg-secondary">

                                    Not Audited

                                </span>

                                @elseif($page->performance_score >= 80)

                                <span class="badge bg-success">

                                    {{ $page->performance_score }}/100

                                </span>

                                @elseif($page->performance_score >= 60)

                                <span class="badge bg-warning text-dark">

                                    {{ $page->performance_score }}/100

                                </span>

                                @else

                                <span class="badge bg-danger">

                                    {{ $page->performance_score }}/100

                                </span>

                                @endif

                            </td>

                            <td>

                                @if($page->auditLogs->count())

                                {{ optional($page->auditLogs->sortByDesc('created_at')->first()->created_at)->diffForHumans() }}

                                @else

                                Never

                                @endif

                            </td>

                            <td>

                                <div class="btn-group btn-group-sm">

                                    <a href="{{ route('seo-pages.show',$page->id) }}"
                                        class="btn btn-info"
                                        title="View">

                                        <i class="fas fa-eye"></i>

                                    </a>

                                    <a href="{{ route('seo-pages.edit',$page->id) }}"
                                        class="btn btn-warning"
                                        title="Edit">

                                        <i class="fas fa-edit"></i>

                                    </a>

                                    <form
                                        action="{{ route('seo-pages.destroy',$page->id) }}"
                                        method="POST"
                                        style="display:inline;">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="btn btn-danger"
                                            onclick="return confirm('Delete this SEO page?')">

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

            <div class="mt-4 d-flex justify-content-center">
                
                @if ($pages->lastPage() > 1)
                <nav>
                    <ul class="pagination justify-content-center">

                        @for ($i = 1; $i <= $pages->lastPage(); $i++)
                            <li class="page-item {{ $pages->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $pages->url($i) }}">
                                    {{ $i }}
                                </a>
                            </li>
                            @endfor

                    </ul>
                </nav>
                @endif

            </div>

            @else

            <div class="text-center py-5">

                <i class="fas fa-search fa-4x text-secondary mb-3"></i>

                <h4>No SEO Pages Found</h4>

                <p class="text-muted">

                    Try another search or create a new SEO page.

                </p>

                <a href="{{ route('seo-pages.create') }}"
                    class="btn btn-primary">

                    <i class="fas fa-plus"></i>

                    Add SEO Page

                </a>

            </div>

            @endif

        </div>

    </div>

</div>

@endsection