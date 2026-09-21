@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">My Profile</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>
        </div>
    </div>

    <div class="mt-3 d-flex gap-2">
        <!-- Edit -->
        <a href="{{ route('profile.edit') }}" class="btn btn-warning">Edit Profile</a>

        <!-- Change Password -->
        <a href="{{ route('password.change') }}" class="btn btn-info">Change Password</a>

        <!-- Delete -->
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete your account?')">
                Delete Account
            </button>
        </form>
    </div>
</div>
@endsection


