@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Change Password</h2>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm p-4">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            @method('PUT')

            <!-- Current Password -->
            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input id="current_password" type="password" 
                       class="form-control @error('current_password') is-invalid @enderror" 
                       name="current_password" required autocomplete="current-password">
                @error('current_password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input id="password" type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input id="password_confirmation" type="password" 
                       class="form-control" 
                       name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary">Update Password</button>
            <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
