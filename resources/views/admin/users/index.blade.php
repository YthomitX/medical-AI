@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">User Management</h1>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Joined</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
                            @csrf
                            @method('PATCH')
                            <select name="role" class="form-select form-select-sm d-inline w-auto">
                                <option value="guest" {{ $user->role === 'guest' ? 'selected' : '' }}>Guest</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center">No users found.</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
