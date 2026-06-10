@extends("main")

@section("content")
<div class="container mt-4">
    <div style="max-width: 500px; margin: 0 auto;">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/plans" class="text-decoration-none">Plany</a></li>
                <li class="breadcrumb-item active">New plan</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h2 class="fw-bold h4 mb-3 text-center">Create new workout plan</h2>

                @if(session('error'))
                <div class="alert alert-danger py-2">
                    {{ session('error') }}
                </div>
                @endif

                <form method="POST">
                    <div class="mb-4">
                        @csrf
                        <label for="plan_name" class="form-label small fw-bold">Plan's name</label>
                        <input type="text"
                            name="plan_name"
                            id="plan_name"
                            class="form-control"
                            placeholder="eg. Split"
                            required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                        Save and add exercises
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection