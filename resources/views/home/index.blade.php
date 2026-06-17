@extends("main")

@section("content")

<div class="container mt-4">
    <div style="max-width: 800px; margin: 0 auto;">

        <div class="mb-4 d-flex justify-content-between align-items-end">
            <div>
                <h2 class="fw-bold text-dark mb-0">Hi, {{ Auth::check() ? Auth::user()->first_name : 'User' }}!</h2>
                <p class="text-muted mb-0">Ready for today's challenge?</p>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #0d6efd, #0a58ca);">
                    <div class="card-body p-4 d-flex flex-column justify-content-between">
                        <div>
                            <div class="mb-3 opacity-50"><i class="bi bi-play-circle-fill display-4"></i></div>
                            <h4 class="fw-bold mb-1">Start a workout</h4>
                            <p class="opacity-75 small">Pick a plan and get started.</p>
                        </div>
                        <div class="mt-3">
                            <a href="/plans" class="btn btn-light text-primary fw-bold w-100 shadow-sm stretched-link">
                                CHOOSE A PLAN
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 d-flex flex-column">
                        <h6 class="fw-bold text-muted text-uppercase small mb-3">Recent activity</h6>

                        @if($lastWorkout && $lastWorkout->plan)
                        <h4 class="fw-bold mb-1 text-truncate">{{ $lastWorkout->plan->name }}</h4>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-calendar-event me-1"></i>
                            {{ \Carbon\Carbon::parse($lastWorkout->workout_date)->format('Y-m-d H:i') }}
                        </p>
                        @else
                        <div class="my-auto">
                            <p class="text-muted mb-0 fw-bold">No history yet.</p>
                            <span class="small text-muted">Complete your first workout!</span>
                        </div>
                        @endif

                        <div class="mt-auto">
                            <hr class="my-3 opacity-10">

                            <a href="/history" class="btn btn-outline-dark btn-sm w-100">
                                Full history
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection