@extends("main")

@section("content")
<div class="container mt-4">
    <div style="max-width: 800px; margin: 0 auto;">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/plans" class="text-decoration-none">Plans</a></li>
                <li class="breadcrumb-item active">Manage plan</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body p-4">
                <h2 class="fw-bold h4 mb-3 text-center">Edit "{{ $model->name }}"</h2>

                @if(session('error'))
                <div class="alert alert-danger py-2">
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="alert alert-success py-2">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="/plans/manage/{{ $model->id }}/update">
                    @csrf
                    <div class="mb-4">
                        <label for="plan_name" class="form-label small fw-bold">Plan's name</label>
                        <input type="text"
                            name="plan_name"
                            id="plan_name"
                            class="form-control"
                            placeholder="eg. Split"
                            value="{{ old('plan_name', $model->name) }}"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                        Change name
                    </button>
                </form>
            </div>

            <div class="card-body bg-light border-top border-bottom p-3">
                <form method="GET" action="" class="d-flex align-items-center gap-2">

                    <div class="fw-bold small text-uppercase text-muted text-nowrap">
                        <i class="bi bi-funnel"></i> Filter:
                    </div>

                    <div class="flex-grow-1">
                        <select name="filter_group" class="form-select form-select-sm border-0" onchange="this.form.submit()">
                            <option value="">All muscle groups</option>
                            @foreach($muscleGroups as $muscleGroup)
                            <option value="{{ $muscleGroup->value }}" {{ request('filter_group') == $muscleGroup->value ? 'selected' : '' }}>
                                {{ $muscleGroup->value }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-grow-1">
                        <select name="filter_source" class="form-select form-select-sm border-0" onchange="this.form.submit()">
                            <option value="all" {{ request('filter_source') == 'all' ? 'selected' : '' }}>All</option>
                            <option value="system" {{ request('filter_source') == 'system' ? 'selected' : '' }}>Default</option>
                            <option value="user" {{ request('filter_source') == 'user' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>

                    <a href="{{ url()->current() }}" class="btn btn-link btn-sm text-muted text-decoration-none" title="Clear">
                        <i class="bi bi-x-circle"></i>
                    </a>
                </form>
            </div>

            <div class="card-body bg-white p-4">
                <form action="/plans/manage/{{ $model->id }}/add-exercise/" method="POST" class="d-flex align-items-end gap-3">
                    @csrf

                    <div class="flex-grow-1">
                        <input type="hidden" name="plan_name" value="{{ $model->name }}">

                        <label class="small fw-bold text-primary mb-1">{{ $exercises->count() }} exercises </label>
                        <select name="exercise_id" class="form-select form-select-lg" required>
                            @if($exercises->isNotEmpty())
                            <option value="" disabled {{ old('exercise_id') === null ? 'selected' : '' }}>Select exercise...</option>
                            @foreach($exercises as $exercise)
                            <option value="{{ $exercise->id }}" {{ old('exercise_id') == $exercise->id ? 'selected' : '' }}>
                                {{ $exercise->name }}
                            </option>
                            @endforeach
                            @else
                            <option value="">No exercises match filtering criteria</option>
                            @endif
                        </select>
                    </div>

                    <div style="width: 120px;">
                        <label class="small fw-bold text-muted mb-1">Series</label>
                        <input type="number" name="series_count" class="form-control form-control-lg" value="{{ old('series_count', 3) }}" min="1" required>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm px-4">
                            ADD
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive bg-white rounded shadow-sm border">
            <table class="table align-middle mb-0 table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px" class="text-center">#</th>
                        <th>Planned exercises</th>
                        <th class="text-center" style="width: 160px;">Series count</th>
                        <th class="text-end" style="width: 150px;">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @if($model->planItems->isNotEmpty())
                    @foreach($model->planItems as $item)
                    <tr>
                        <td class="text-center fw-bold text-muted">{{ $item->order }}.</td>

                        <td class="fw-semibold">{{ $item->exercise->name }}</td>

                        <td class="text-center">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <a href="/plan/decrement-series/{{ $item->id }}"
                                    class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 28px; height: 28px;"
                                    title="Lower series">
                                    <i class="bi bi-dash-lg"></i>
                                </a>

                                <span class="badge bg-white text-dark border px-3 py-2 rounded-pill" style="min-width: 40px;">
                                    {{ $item->series_count }}
                                </span>

                                <a href="/plan/increment-series/{{ $item->id }}"
                                    class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 28px; height: 28px;"
                                    title="Add series">
                                    <i class="bi bi-plus-lg"></i>
                                </a>
                            </div>
                        </td>

                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end gap-2">
                                <a href="/plan/decrement-order/{{ $item->id }}"
                                    class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 28px; height: 28px;"
                                    title="Move up">
                                    <i class="bi bi-arrow-up"></i>
                                </a>

                                <a href="/plan/increment-order/{{ $item->id }}"
                                    class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 28px; height: 28px;"
                                    title="Move down">
                                    <i class="bi bi-arrow-down"></i>
                                </a>

                                <a href="/plan/remove-exercise/{{ $item->id }}"
                                    class="btn btn-sm text-danger ms-2"
                                    onclick="return confirm('Remove this exercise from plan?')">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            This workout plan is empty.
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex align-items-center justify-content-between gap-2">
            <a href="/plans" class="btn btn-secondary btn-lg px-4 shadow-sm fw-bold rounded-pill d-flex align-items-center justify-content-center">
                <i class="bi bi-arrow-left me-2"></i> Back to plans
            </a>

            <a href="/start-workout/{{ $model->id }}" class="btn btn-success btn-lg px-5 shadow fw-bold rounded-pill d-flex align-items-center justify-content-center">
                Start workout <i class="bi bi-play-fill ms-2"></i>
            </a>
        </div>

    </div>
</div>
@endsection