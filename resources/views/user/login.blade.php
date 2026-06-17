@extends("main")

@section("content")
<div class="container mt-5">
    <div style="max-width: 500px; margin: 0 auto;">

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h1 class="text-center fw-bold h3 mb-4">Log in</h1>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="/login" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-bold">Email address</label>
                        <input type="email" class="form-control" name="email" id="email"
                            value="{{ old('email') }}"
                            required>
                        @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label small fw-bold">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-3">Log in</button>

                    @if(session('error'))
                    <div class="alert alert-danger py-2 small text-center">{{ session('error') }}</div>
                    @endif
                </form>

                <div class="text-center mt-3">
                    <p class="text-muted small">If you don't have an account, <a href="/register" class="text-decoration-none fw-bold">register first</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection