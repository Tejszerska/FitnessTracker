@extends("main")

@section("content")
<div class="container mt-4">
    <div style="max-width: 500px; margin: 0 auto;">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/exercises" class="text-decoration-none">Exercises</a></li>
                <li class="breadcrumb-item active">Custom exercise</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="text-center mb-4 h4">Creating an exercise</h2>

                @if(session('success'))
                <div class="alert alert-success py-2">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                <form method="POST">
                    @csrf

                    <input value="6" name="user_id" hidden> {{-- hardcoded for now @TODO --}}

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold small">Exercise name</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                    </div>

                    <div class=" mb-3">
                        <label for="muscle_group" class="form-label fw-bold small">Muscle group</label>
                        <select class="form-select" id="muscle_group" name="muscle_group" required>
                            <option value="" disabled {{ old('muscle_group') === null ? 'selected' : '' }}>Pick a muscle group...</option>
                            @foreach($muscleGroups as $muscleGroup)
                            <option value="{{ $muscleGroup->value }}" {{ old('muscle_group') == $muscleGroup->value ? 'selected' : '' }}>
                                {{ $muscleGroup->value }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4 p-3 bg-light rounded border-0">
                        <label class="form-label d-block fw-bold small mb-2 text-muted">TRACKED PARAMETERS</label>

                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="has_weight" name="has_weight" value="1"
                                {{ old('has_weight') || (old('_token') === null) ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_weight">Weight (kg)</label>
                        </div>

                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="has_reps" name="has_reps" value="1"
                                {{ old('has_reps') || (old('_token') === null) ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_reps">Reps</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="has_duration" name="has_duration" value="1"
                                {{ old('has_duration') ? 'checked' : '' }}>
                            <label class="form-check-label" for="has_duration">Duration [seconds]</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection