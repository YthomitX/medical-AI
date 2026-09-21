@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Forgot Password</h2>

    <div class="mb-3 text-muted">
        Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
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

    <form method="POST" action="{{ route('password.email') }}" class="card p-3 p-sm-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" name="email"
                   class="form-control form-control-lg"
                   value="{{ old('email') }}" required autofocus>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2">
            <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                Email Password Reset Link
            </button>
            <a href="{{ route('login') }}" class="btn btn-secondary w-100 w-sm-auto">
                Back to Login
            </a>
        </div>
    </form>
</div>
@endsection

