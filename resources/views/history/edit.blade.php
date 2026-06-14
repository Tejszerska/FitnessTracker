@extends("main")

@section("content")

<div class="container mt-4 pb-5">
    <div style="max-width: 800px; margin: 0 auto;">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/history" class="text-decoration-none">History</a></li>
                <li class="breadcrumb-item active">Editing: {{ $plan->name }}</li>
            </ol>
        </nav>

        <h2 class="fw-bold mb-4 h3">Edit workout</h2>

        <form method="GET" action="/history/edit/{{ $workout->id }}/update">
            @csrf

            @foreach($plan->planItems as $item)
            @php
            $ex = $item->exercise;
            @endphp

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-primary m-0">{{ $ex->name }}</h5>
                        <span class="badge bg-light text-dark border">Goal: {{ $item->series_count }} series</span>
                    </div>
                </div>

                <div class="card-body p-0">
                    <table class="table align-middle mb-0">
                        <thead class="table-light small text-muted text-uppercase">
                            <tr class="text-center">
                                <th style="width: 50px;">#</th>
                                @if($ex->has_weight) <th>kg</th> @endif
                                @if($ex->has_reps) <th>reps</th> @endif
                                @if($ex->has_duration) <th>time (s)</th> @endif
                                <th style="width: 80px;">Rest</th>
                                <th style="width: 50px;" title="Superset">SS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <= $item->series_count; $i++)
                                @php
                                // getting values for the inputs (from db)
                                $savedSet = $workout->sets
                                ->where('exercise_id', $ex->id)
                                ->where('set_number', $i)
                                ->first();
                                @endphp
                                <tr>
                                    <td class="text-center fw-bold text-muted">{{ $i }}</td>

                                    @if($ex->has_weight)
                                    <td class="p-1">
                                        <input type="number"
                                            name=" sets[{{ $ex->id }}][{{ $i }}][weight]"
                                            class="form-control form-control-sm text-center"
                                            value="{{ old("sets.{$ex->id}.{$i}.weight", $savedSet->weight ?? '') }}">
                                    </td>
                                    @endif

                                    @if($ex->has_reps)
                                    <td class="p-1">
                                        <input type="number"
                                            name="sets[{{ $ex->id }}][{{ $i }}][reps]"
                                            class="form-control form-control-sm text-center"
                                            value="{{ old("sets.{$ex->id}.{$i}.reps", $savedSet->reps ?? '') }}">
                                    </td>
                                    @endif

                                    @if($ex->has_duration)
                                    <td class="p-1">
                                        <input type="number"
                                            name="sets[{{ $ex->id }}][{{ $i }}][duration_seconds]"
                                            class="form-control form-control-sm text-center"
                                            value="{{ old("sets.{$ex->id}.{$i}.duration_seconds", $savedSet->duration_seconds ?? '') }}">
                                    </td>
                                    @endif

                                    <td class="p-1">
                                        <input type="number"
                                            name="sets[{{ $ex->id }}][{{ $i }}][rest_interval]"
                                            class="form-control form-control-sm text-center text-muted"
                                            placeholder="s"
                                            value="{{ old("sets.{$ex->id}.{$i}.rest_interval", $savedSet->rest_interval ?? '') }}">
                                    </td>

                                    <td class="text-center">
                                        <input type="checkbox" value="1"
                                            name="sets[{{ $ex->id }}][{{ $i }}][is_superset]"
                                            class="form-check-input"
                                            {{ old("sets.{$ex->id}.{$i}.is_superset", $savedSet->is_superset ?? false) ? 'checked' : '' }}>
                                    </td>
                                    @endfor
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach

            <div class="text-center mt-5 mb-5">
                <button type="submit" class="btn btn-success btn-lg px-5 shadow fw-bold rounded-pill">
                    SAVE<i class="bi bi-check2-circle"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection