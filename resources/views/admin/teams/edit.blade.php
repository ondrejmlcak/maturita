@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Název týmu</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $team->name }}" maxlength="20" required>
        </div>
        <div class="mb-3">
            <label for="league_id" class="form-label">Liga, do které spadá</label>
            <select class="form-select" id="league_id" name="league_id" required>
                @foreach ($leagues as $league)
                    <option value="{{ $league->id }}" {{ $team->league_id == $league->id ? 'selected' : '' }}>
                        {{ $league->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Obrázek týmu</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/png, image/jpg, image/jpeg">
        </div>
        @if ($team->image)
            <div class="mb-3">
                <p>Current Image:</p>
                <img src="{{ asset('storage/' . $team->image) }}" alt="{{ $team->name }}" width="200">
            </div>
        @endif

        <button type="submit" class="btn btn-warning submit-once">Upravit</button>
        <a href="{{ route('admin.teams.index') }}" class="btn btn-secondary">Zpět</a>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                form.addEventListener('submit', function () {
                    const submitButton = form.querySelector('button.submit-once');

                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.innerText = 'Probíhá...';
                    }
                });
            });
        });
    </script>
@endsection
