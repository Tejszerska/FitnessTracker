@extends("main")

@section("content")
<div class="container mt-4 mb-5">
    <div style="max-width: 800px; margin: 0 auto;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active">History</li>
                    </ol>
                </nav>
                <h2 class="fw-bold m-0 h3">Workout History</h2>
            </div>
        </div>

        @if(session('success'))
        <div class="alert alert-success py-2">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger py-2">
            {{ session('error') }}
        </div>
        @endif

        <div class="card border-0 shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Date</th>
                        <th>Workout Plan</th>
                        <th class="text-end pe-4">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @if($workouts->isNotEmpty())
                    @foreach($workouts as $workout)
                    <tr>
                        <td class="fw-semibold text-dark ps-4">
                            <i class="bi bi-calendar-event text-muted me-2"></i>
                            {{ \Carbon\Carbon::parse($workout->workout_date)->format('d.m.Y') }}
                        </td>

                        <td>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                                {{ $workout->plan->name }}
                            </span>
                        </td>

                        <td class="text-end pe-4">
                            <a href="/history/{{ $workout->id }}" class="text-info text-decoration-none" title="View Details">
                                <i class="bi bi-eye-fill me-1"> </i>
                            </a>

                            <a href="/history/edit/{{ $workout->id }}" class=" text-info text-decoration-none" title=" Edit">
                                <i class="bi bi-pencil-fill text-secondary"> </i>
                            </a>

                            <a href="/history/delete/{{ $workout->id }}"
                                class="text-danger text-decoration-none"
                                onclick="return confirm('Are you sure you want to delete this workout record?')"
                                title="Delete">
                                <i class="bi bi-trash3-fill"></i>
                            </a>
        </div>
        </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="3" class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-calendar-x display-4 text-muted opacity-50"></i>
                </div>
                <h5 class="text-muted">No workouts recorded yet.</h5>
                <p class="text-muted small mb-0">Hit the gym and start tracking!</p>
            </td>
        </tr>
        @endif
        </tbody>
        </table>
    </div>
</div>

</div>
</div>
@endsection