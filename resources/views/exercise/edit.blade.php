@extends("main")

@section("content")
<div class="container mt-4">
    <div style="max-width: 500px; margin: 0 auto;">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/exercises" class="text-decoration-none">Exercises</a></li>
                <li class="breadcrumb-item active">Edit exercise</li>
            </ol>
        </nav>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h2 class="text-center mb-4 h4">Editing an exercise</h2>

                {{--
                <?php if ($blad_msg): ?>
                    <div class="alert alert-danger py-2"><?php echo htmlspecialchars($blad_msg); ?></div>
                <?php endif; ?>

                <?php if ($sukces_msg): ?>
                    <div class="alert alert-success py-2"><?php echo htmlspecialchars($sukces_msg); ?></div>
                <?php endif; ?>
                --}}


                <form method="POST">
                    @csrf

                    <input value="6" name="user_id" hidden> {{-- hardcoded for now @TODO --}}
                    <div class="mb-3">
                        <label for="nazwa" class="form-label fw-bold small">Exercise name</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $model->name) }}">
                    </div>

                    <div class="mb-3">
                        <label for="muscle_group" class="form-label fw-bold small">Muscle group</label>
                        <select class="form-select" id="muscle_group" name="muscle_group" required>
                            <option value="" selected disabled>Pick a muscle group...</option>
                            @foreach($muscleGroups as $muscleGroup)
                            <option value="{{ $muscleGroup->value }}"
                                {{ old('muscle_group', $model->muscle_group->value) === $muscleGroup->value ? 'selected' : '' }}>
                                {{ $muscleGroup->value }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4 p-3 bg-light rounded border-0">
                        <label class="form-label d-block fw-bold small mb-2 text-muted">TRACKED PARAMETERS</label>

                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="has_weight" name="has_weight" checked>
                            <label class="form-check-label" for="has_weight">Weight (kg)</label>
                        </div>

                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" id="has_reps" name="has_reps" checked>
                            <label class="form-check-label" for="has_reps">Reps</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="has_duration" name="has_duration">
                            <label class="form-check-label" for="has_duration">Duration [seconds]</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection