@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Login</h2>

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

    <form method="POST" action="{{ route('login') }}" class="card p-3 p-sm-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email"
                   class="form-control form-control-lg"
                   value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password"
                   class="form-control form-control-lg"
                   required>
        </div>

        <div class="d-flex flex-column flex-sm-row gap-2">
            <button type="submit" class="btn btn-primary w-100 w-sm-auto">Login</button>
            <a href="{{ route('register') }}" class="btn btn-secondary w-100 w-sm-auto">Register</a>
        </div>
    </form>
</div>
@endsection
