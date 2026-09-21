@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Confirm Password</h2>

    <div class="mb-3 text-muted">
        This is a secure area of the application. Please confirm your password before continuing.
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('password.confirm') }}" class="card p-3 p-sm-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password"
                   class="form-control form-control-lg"
                   required autocomplete="current-password">
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2">
            <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                Confirm
            </button>
            <a href="{{ route('login') }}" class="btn btn-secondary w-100 w-sm-auto">
                Back to Login
            </a>
        </div>
    </form>
</div>
@endsection
