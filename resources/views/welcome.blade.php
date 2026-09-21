@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h1 class="mb-4">Welcome to the Medical AI System</h1>
    <p class="lead mb-5">
        Manage your SOPs, Policies, and Health Advisories, or ask the AI chatbot for guidance.
    </p>

    <!-- ✅ Responsive button group -->
    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
        <!-- AI Chatbot Button (always visible) -->
        <a href="{{ route('chatbot.index') }}" 
           class="btn btn-success btn-lg w-100 w-sm-auto">
            AI Chatbot
        </a>

        <!-- Policies Button (always visible) -->
        <a href="{{ route('policies.index') }}" 
           class="btn btn-secondary btn-lg w-100 w-sm-auto">
            View Policies
        </a>

        <!-- Admin-only buttons -->
       @auth
            @if(Auth::user()->is_admin)
                <a href="{{ route('policies.create') }}" 
                class="btn btn-primary btn-lg w-100 w-sm-auto">
                    Upload Policy
                </a>

                <!-- ✅ Fixed: Admin Dashboard button -->
                <a href="{{ route('dashboard') }}" 
                class="btn btn-warning btn-lg w-100 w-sm-auto">
                    Admin Dashboard
                </a>
            @endif
        @endauth

    </div>
</div>
@endsection


