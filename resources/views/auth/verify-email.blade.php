@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Verify Your Email</h2>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <div class="card p-3 p-sm-4 shadow-sm">
        <p class="mb-3">
            Before proceeding, please check your email for a verification link.
            If you did not receive the email, you can request another below.
        </p>

        <form method="POST" action="{{ route('verification.send') }}" class="d-flex flex-column flex-sm-row gap-2">
            @csrf
            <button type="submit" class="btn btn-primary w-100 w-sm-auto">
                Resend Verification Email
            </button>
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
               class="btn btn-danger w-100 w-sm-auto">
                Logout
            </a>
        </form>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
            @csrf
        </form>
    </div>
</div>
@endsection

