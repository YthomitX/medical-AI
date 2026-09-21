@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Upload New Policy</h1>

    <form action="{{ route('policies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Policy Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
            @error('title') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="file" class="form-label">Policy File (PDF)</label>
            <input type="file" name="file" id="file" class="form-control" accept=".pdf" required>
            @error('file') <div class="text-danger">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Upload</button>
        <a href="{{ route('policies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
