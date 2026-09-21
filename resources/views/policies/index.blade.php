@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Policies</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- ✅ Search + Sort + Per Page bar -->
    <form method="GET" action="{{ route('policies.index') }}" class="row mb-3 g-2">
        <div class="col-md-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" 
                       placeholder="Search policies by title..." 
                       value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <label class="input-group-text" for="sort">Sort by</label>
                <select name="sort" id="sort" class="form-select" onchange="this.form.submit()">
                    <option value="created_at" {{ $sort === 'created_at' ? 'selected' : '' }}>Upload Date</option>
                    <option value="title" {{ $sort === 'title' ? 'selected' : '' }}>Title</option>
                    <option value="uploaded_by" {{ $sort === 'uploaded_by' ? 'selected' : '' }}>Uploader</option>
                </select>
                <select name="direction" class="form-select" onchange="this.form.submit()">
                    <option value="asc" {{ $direction === 'asc' ? 'selected' : '' }}>Ascending</option>
                    <option value="desc" {{ $direction === 'desc' ? 'selected' : '' }}>Descending</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <label class="input-group-text" for="perPage">Records per page</label>
                <select name="perPage" id="perPage" class="form-select" onchange="this.form.submit()">
                    <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                </select>
                <!-- ✅ Clear Filters button -->
                <a href="{{ route('policies.index') }}" class="btn btn-outline-secondary">Clear Filters</a>

                <!-- ✅ Export dropdown -->
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Export
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('policies.export', array_merge(request()->query(), ['format' => 'csv'])) }}">
                                Export CSV
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('policies.export', array_merge(request()->query(), ['format' => 'excel'])) }}">
                                Export Excel
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </form>

    <!-- ✅ Upload button only for admins -->
    @if(Auth::check() && Auth::user()->is_admin)
        <a href="{{ route('policies.create') }}" class="btn btn-primary mb-3">Upload New Policy</a>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Title</th>
                <th>Filename</th>
                <th>Uploaded By</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($policies as $policy)
                <tr>
                    <td>{{ $policy->title }}</td>
                    <td>{{ $policy->filename }}</td>
                    <td>{{ $policy->uploaded_by }}</td>
                    <td class="d-flex flex-column flex-sm-row gap-2">
                        <!-- ✅ Preview always available -->
                        @if($policy->path)
                            <button type="button" class="btn btn-sm btn-info w-100 w-sm-auto" 
                                    data-bs-toggle="modal" data-bs-target="#previewModal{{ $policy->id }}">
                                Preview
                            </button>
                            <div class="modal fade" id="previewModal{{ $policy->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title">Preview: {{ $policy->title }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body" style="height:80vh;">
                                            <iframe src="{{ asset('storage/' . $policy->path) }}" 
                                                    frameborder="0" width="100%" height="100%"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ✅ Download always available -->
                            <a href="{{ asset('storage/' . $policy->path) }}" 
                               class="btn btn-sm btn-success w-100 w-sm-auto" download>
                                Download
                            </a>
                        @endif

                        <!-- ✅ Edit/Delete only for admins -->
                        @if(Auth::check() && Auth::user()->is_admin)
                            <a href="{{ route('policies.edit', $policy) }}" 
                               class="btn btn-sm btn-warning w-100 w-sm-auto">Edit</a>

                            <form action="{{ route('policies.destroy', $policy) }}" method="POST" class="d-inline w-100 w-sm-auto">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100 w-sm-auto"
                                        onclick="return confirm('Delete this policy?')">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">No policies found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- ✅ Record counter + Pagination -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            Showing {{ $policies->firstItem() }}–{{ $policies->lastItem() }} of {{ $policies->total() }} records
        </div>
        <div>
            {{ $policies->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
