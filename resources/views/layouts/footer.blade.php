<footer class="bg-dark text-light mt-5 py-3">
    <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center">
        <!-- Left side -->
        <div class="mb-2 mb-sm-0">
            <small>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</small>
        </div>

        <!-- Right side links -->
        <div>
            <a href="{{ route('policies.index') }}" class="text-light me-3">Policies</a>
            <a href="{{ route('profile.edit') }}" class="text-light me-3">Account</a>
            <a href="mailto:info@hospital.org" class="text-light">Contact</a>
        </div>
    </div>
</footer>
