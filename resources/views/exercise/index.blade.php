@extends("main")

@section("content")

<div class="container mt-4">
    <div style="max-width: 800px; margin: 0 auto;">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold m-0 h3">Exercise Library</h2>
            <a href="/exercises/add" class="btn btn-primary fw-bold shadow-sm">
                <i class="bi bi-plus-lg"></i> Add exercise
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
            <form method="GET" class="d-flex gap-2">

                <div class="flex-grow-1">
                    <select name="group" class="form-select border-0">
                        <option value="">All muscle groups...</option>
                        @foreach($muscleGroups as $muscleGroup)
                        <option value="{{ $muscleGroup->value }}">{{ $muscleGroup->value }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex-grow-1">
                    <select name="type" class="form-select border-0">
                        <option value="all">All exercises</option>
                        <option value="system">System</option>
                        <option value="user">Custom</option>
                    </select>
                </div>

                <div>
                    <button type="submit" class="btn btn-dark px-4">Filter</button>
                </div>
            </form>
        </div>

        <div class="card border-0 shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="text-center" style="width: 60px;">#</th>
                        <th>Name</th>
                        <th style="width: 180px;">Group</th>
                        <th class="text-center" style="width: 120px;">Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($models as $model)
                    <tr>
                        <td class="text-center">
                            @if ( $model->user_id !== null )
                            <a href="/exercises/delete/{{ $model->id }}"
                                class="text-danger text-decoration-none"
                                onclick="return confirm('Delete exercise?')"
                                title="Delete exercise">
                                <i class="bi bi-trash3-fill"></i>
                            </a>

                            <a href="/exercises/edit/{{ $model->id }}"
                                class="text-info text-decoration-none"
                                onclick=""
                                title="Edit exercise">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            @else
                            <span class="text-muted opacity-50"><i class="bi bi-hdd-stack"></i></span>
                            @endif
                        </td>

                        <td class="fw-semibold">
                            {{ $model->name }}
                        </td>

                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('img/muscles/' . str_replace(' ', '_', $model->muscle_group->value) . '.png') }}" alt="" style="width: 20px; margin-right: 8px;">

                                <span class="small text-muted">{{ $model->muscle_group->value }}</span>
                            </div>
                        </td>

                        <td class="text-center text-muted">
                            <div class="d-flex justify-content-center gap-2">
                                @if( $model->has_weight === 1 )
                                <i class="bi bi-clipboard2-data text-primary" title="Weight"></i>
                                @endif

                                @if( $model->has_reps === 1 )
                                <i class="bi bi-123 text-success" title="Reps"></i>
                                @endif

                                @if( $model->has_duration === 1 )
                                <i class="bi bi-stopwatch text-warning" title="Time"></i>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection