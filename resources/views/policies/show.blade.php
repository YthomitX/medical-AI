@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Policy Details</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title">{{ $policy->title }}</h4>
            <p class="card-text"><strong>Filename:</strong> {{ $policy->filename }}</p>
            <p class="card-text"><strong>Uploaded By:</strong> {{ $policy->uploaded_by }}</p>
            <p class="card-text"><strong>Uploaded At:</strong> {{ $policy->created_at->format('M d, Y h:i A') }}</p>

            <!-- ✅ Download link always available -->
            @if($policy->path)
                <a href="{{ asset('storage/' . $policy->path) }}" class="btn btn-success" download>
                    Download File
                </a>
            @endif

            <!-- ✅ Action buttons -->
            <div class="mt-3 d-flex flex-column flex-sm-row gap-2">
                <!-- Edit/Delete only for admins -->
                @if(Auth::check() && Auth::user()->is_admin)
                    <a href="{{ route('policies.edit', $policy) }}" class="btn btn-warning w-100 w-sm-auto">Edit</a>
                    <form action="{{ route('policies.destroy', $policy) }}" method="POST" class="d-inline w-100 w-sm-auto">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 w-sm-auto"
                                onclick="return confirm('Delete this policy?')">Delete</button>
                    </form>
                @endif

                <!-- Back to list always available -->
                <a href="{{ route('policies.index') }}" class="btn btn-secondary w-100 w-sm-auto">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection

