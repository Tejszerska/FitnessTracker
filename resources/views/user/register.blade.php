@extends("main")

@section("content")
<div class="container mt-5">
    <div style="max-width: 500px; margin: 0 auto;">

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h1 class="text-center fw-bold h3 mb-4">FitnessTracker Registration</h1>

                <form action="/register" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="first_name" class="form-label small fw-bold">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name"
                            value="{{ old('first_name') }}" required>
                        @error('first_name')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold">Email address</label>
                        <input type="email" class="form-control" name="email" id="email"
                            value="{{ old('email') }}" required>
                        @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label small fw-bold">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="form-text small text-muted">Minimum 8 characters.</div>
                        @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label small fw-bold">Password confirmation</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        @error('password_confirmation')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-3">Register</button>

                    @if(session('error'))
                    <div class="alert alert-danger py-2 small text-center">{{ session('error') }}</div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success py-2 small text-center">{{ session('success') }}</div>
                    @endif
                </form>

                <div class="text-center mt-2">
                    <p class="text-muted small">If you already have an account, <a href="/login" class="text-decoration-none fw-bold">log in</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection