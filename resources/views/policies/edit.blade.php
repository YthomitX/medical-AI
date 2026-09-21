@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Policy</h1>

    <form action="{{ route('policies.update', $policy) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Policy Title</label>
            <input type="text" name="title" id="title" 
                   class="form-control form-control-lg"
                   value="{{ old('title', $policy->title) }}" required>
            @error('title')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- File Upload -->
        <div class="mb-3">
            <label for="file" class="form-label">Replace File (optional)</label>
            <input type="file" name="file" id="file" class="form-control" accept=".pdf,.doc,.docx">
            <p class="small text-muted mt-1">Current file: {{ $policy->filename }}</p>
            @error('file')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="d-flex flex-column flex-sm-row gap-2">
            <button type="submit" class="btn btn-primary w-100 w-sm-auto">Update Policy</button>
            <button type="button" class="btn btn-danger w-100 w-sm-auto" data-bs-toggle="modal" data-bs-target="#cancelModal">
                Cancel
            </button>
        </div>

        <!-- Cancel Confirmation Modal -->
        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="cancelModalLabel">Confirm Cancel</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to cancel? Unsaved changes will be lost.
                    </div>
                    <div class="modal-footer flex-column flex-sm-row gap-2">
                        <button type="button" class="btn btn-primary w-100 w-sm-auto" data-bs-dismiss="modal">Stay on Page</button>
                        <a href="{{ route('policies.index') }}" class="btn btn-danger w-100 w-sm-auto">Yes, Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection




