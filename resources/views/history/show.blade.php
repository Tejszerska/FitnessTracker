@extends("main")

@section("content")
<div class="container mt-4 mb-5">
    <div style="max-width: 400px; margin: 0 auto;">
        @foreach($workout->sets->groupBy('exercise_id') as $exerciseId => $sets)

        @php $ex = $sets->first()->exercise; @endphp

        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold text-primary m-0">{{ $ex->name }}</h5>
            </div>

            <div class="card-body p-0">
                <table class="table align-middle mb-0">
                    <thead class="table-light small text-muted text-uppercase text-center">
                        <tr>
                            <th style="width: 50px;">Set</th>
                            @if($ex->has_weight) <th>Weight</th> @endif
                            @if($ex->has_reps) <th>Reps</th> @endif
                            @if($ex->has_duration) <th>Time</th> @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sets as $set)
                        <tr class="text-center">
                            <td class="fw-bold text-muted">{{ $set->set_number }}</td>
                            @if($ex->has_weight) <td>{{ $set->weight }} kg</td> @endif
                            @if($ex->has_reps) <td>{{ $set->reps }}</td> @endif
                            @if($ex->has_duration) <td>{{ $set->duration_seconds }} s</td> @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @endforeach
    </div>
</div>
@endsection