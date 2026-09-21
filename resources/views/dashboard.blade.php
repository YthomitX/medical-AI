@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Admin Dashboard</h2>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card p-3 p-sm-4 shadow-sm mb-4">
        <h5 class="card-title">Welcome, {{ Auth::user()->name }}!</h5>
        <p class="card-text">
            You are logged in as an administrator. Use the dashboard below to manage system modules.
        </p>
    </div>

    <div class="row g-3">
        <!-- ✅ Policies -->
        <div class="col-md-6">
            <div class="card p-3 shadow-sm h-100">
                <h5 class="card-title">Policies</h5>
                <p class="card-text">Upload, edit, and manage medical policies.</p>
                <a href="{{ route('policies.index') }}" class="btn btn-primary">Go to Policies</a>
            </div>
        </div>

        <!-- ✅ Account Settings -->
        <div class="col-md-6">
            <div class="card p-3 shadow-sm h-100">
                <h5 class="card-title">Account Settings</h5>
                <p class="card-text">Update your profile, change password, and manage preferences.</p>
                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">Manage Account</a>
            </div>
        </div>

        <!-- ✅ Admin-only modules -->
        <div class="col-md-6">
            <div class="card p-3 shadow-sm h-100">
                <h5 class="card-title">User Management</h5>
                <p class="card-text">Promote/demote accounts and manage access rights.</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-warning">Manage Users</a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-3 shadow-sm h-100">
                <h5 class="card-title">Reports</h5>
                <p class="card-text">View system logs, analytics, and audit reports.</p>
                <a href="#" class="btn btn-info">View Reports</a>
            </div>
        </div>
    </div>
</div>
@endsection
