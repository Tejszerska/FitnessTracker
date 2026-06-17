@extends("main")

@section("content")

<div class="container mt-4 mb-5">
    <div style="max-width: 900px; margin: 0 auto;">

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

        <div class="bg-light p-3 rounded border mb-4">
            <form method="GET" action="" class="d-flex gap-3 align-items-center">

                <div class="d-flex align-items-center gap-2 flex-grow-1">
                    <label for="search_name" class="form-label small fw-bold mb-0 text-nowrap">Search plan by its name:</label>
                    <input type="text"
                        name="search_name"
                        id="search_name"
                        class="form-control"
                        placeholder="eg. Split"
                        value="{{ request('search_name') }}">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark px-4">Search</button>
                    <a href="/plans" class="btn btn-dark px-4" title="Clear filter">
                        Clear
                    </a>
                </div>
            </form>
        </div>

        <div class="row g-4">
            @if($models->isNotEmpty())
            @foreach($models as $model)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4 d-flex flex-column">

                        <h5 class="fw-bold text-primary mb-4 text-center">{{ $model->name }}</h5>

                        <div class="mt-auto d-flex flex-column gap-2">
                            <a href="/start-workout/{{ $model->id }}" class="btn btn-success fw-bold w-100 shadow-sm py-2">
                                START <i class="bi bi-play-fill"></i>
                            </a>

                            <div class="btn-group w-100 shadow-sm">
                                <a href="/plans/edit/{{ $model->id }}" class="btn btn-light border" title="Edit">
                                    <i class="bi bi-gear-fill text-secondary"></i>
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
            </div>
            @endforeach

            @else
            <div class="col-12">
                <div class="text-center py-5 bg-white rounded shadow-sm border w-100">
                    <div class="mb-3">
                        <i class="bi bi-journal-plus display-4 text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted">No workout plan available.</h5>
                    <p class="text-muted small mb-4">Create your first workout plan!</p>
                    <a href="/plans/add" class="btn btn-primary px-4">Create</a>
                </div>
            </div>
            @endif

        </div>

    </div>
</div>

@endsection