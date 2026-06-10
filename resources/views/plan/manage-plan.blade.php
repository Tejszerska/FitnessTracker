@extends("main")

@section("content")

<div class="container mt-4">
    <div style="max-width: 800px; margin: 0 auto;">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="plans.php" class="text-decoration-none">Plans</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage {{ $model->name }}</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0 mb-4 overflow-hidden">

            <div class="card-body bg-light border-bottom p-3">
                <form method="POST" class="d-flex align-items-center gap-2">
                    @csrf

                    <input type="hidden" name="id" value="{{ $model->plan_id }}">

                    <div class="fw-bold small text-uppercase text-muted text-nowrap">
                        <i class="bi bi-funnel"></i> Filter:
                    </div>

                    <div class="flex-grow-1">
                        <select name="filter_group" class="form-select form-select-sm border-0" onchange="this.form.submit()">
                            <option value="">All muscle groups</option>
                            @foreach($muscleGroups as $muscleGroup)
                            <option value="{{ $muscleGroup->value }}">{{ $muscleGroup->value }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="flex-grow-1">
                        <select name="filter_source" class="form-select form-select-sm border-0" onchange="this.form.submit()">
                            <option value="all" selected>All</option>
                            <option value="system">Default</option>
                            <option value="user">Custom</option>
                        </select>
                    </div>


                    <a href="manage-plan/{{ $model->plan_id }}" class="btn btn-link btn-sm text-muted text-decoration-none" title="Clear">
                        <i class="bi bi-x-circle"></i>
                    </a>
                </form>
            </div>

            <div class="card-body bg-white p-4">
                <form method="POST" class="d-flex align-items-end gap-3">
                    @csrf
                    <div class="flex-grow-1">

                        <input type="hidden" name="plan_name" value="{{ $model->name }}">

                        <label class="small fw-bold text-primary mb-1">{{ $exercises->count() }} exercises </label>
                        <select name="exercise_id" class="form-select form-select-lg" required>
                            @if($exercises->isNotEmpty())
                            @foreach($exercises as $exercise)
                            <option value="{{ $muscleGroup->value }}">{{ $exercise->name }}</option>
                            @endforeach
                            @else
                            <option value="">No exercises match filtering criteria</option>
                            @endif
                        </select>
                    </div>

                    <div style="width: 120px;">
                        <label class="small fw-bold text-muted mb-1">Series</label>
                        <input type="number" name="series_count" class="form-control form-control-lg" value="3" min="1" required>
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
                        <th class="text-center">Series count</th>
                        <th class="text-end">Options</th>
                    </tr>
                </thead>
                <tbody>
                    @if($model->planItems->isNotEmpty() )
                    @foreach($model->planItems() as $exercise)
                    <tr>
                        <td class="text-center fw-bold text-muted">{{ $exercise->order }}.</td>
                        <td class="fw-semibold">{{ $exercise->Exercise()->name }}</td>
                        <td class="text-center">
                            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill">{{ $exercise->series_count }}</span>
                        </td>
                        <td class="text-end">
                            <a href="remove-from-plan/{{ $model->id }}"
                                class="btn btn-sm text-danger"
                                onclick="return confirm('Remove this exercise from plan?')">
                                <i class="bi bi-trash3-fill"></i>
                            </a>
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

        <div class="mt-4 text-center">
            <a href="start-workout/{{ $model->id }}" class="btn btn-success btn-lg px-5 shadow fw-bold rounded-pill">
                STAR WORKOUT NOW! <i class="bi bi-play-fill"></i>
            </a>
        </div>
    </div>
</div>

@endsection