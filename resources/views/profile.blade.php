@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">My Profile</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Joined:</strong> {{ Auth::user()->created_at->format('M d, Y') }}</p>
        </div>
    </div>

    <a href="{{ route('welcome') }}" class="btn btn-outline-primary mt-3">Back to Home</a>
</div>
@endsection
