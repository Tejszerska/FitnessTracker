@extends("main")

@section("content")

<div class="container mt-4">
    <div style="max-width: 800px; margin: 0 auto;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold m-0 h3">My workout plans</h2>
            <a href="/plans/add" class="btn btn-primary shadow-sm fw-bold">
                <i class="bi bi-plus-lg"></i> Add a plan
            </a>
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

        <div class="d-flex flex-column gap-3">
            @if($models->isNotEmpty())
            @foreach($models as $model)
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">

                    <div>
                        <h5 class="fw-bold text-primary mb-1">{{ $model->name }}</h5>
                        <div class="text-muted small">
                            <a href="**********************" class="text-decoration-none text-secondary">
                                <i class="bi bi-pencil-square"></i> Edit exercises
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2">
                        <a href=" **** **** **** TODO *** *** *** *** " class="btn btn-success fw-bold px-4 shadow-sm">
                            START <i class="bi bi-play-fill"></i>
                        </a>

                        <div class="btn-group">
                            <a href="/plans/edit/{{ $model->id }}" class="btn btn-light border" title="Edit">
                                <i class="bi bi-gear-fill"></i>
                            </a>
                            <a href="/plans/delete/{{ $model->id }}"
                                class="btn btn-light border text-danger"
                                onclick="return confirm('Are you sure you want to delete this workout plan?')"
                                title="Delete">
                                <i class="bi bi-trash3-fill"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
            @else
            <div class="text-center py-5 bg-white rounded shadow-sm border">
                <div class="mb-3">
                    <i class="bi bi-journal-plus display-4 text-muted opacity-50"></i>
                </div>
                <h5 class="text-muted">No workout plan availible.</h5>
                <p class="text-muted small mb-4">Create your first workout plan!</p>
                <a href="/plans/add" class="btn btn-primary px-4">Create</a>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection