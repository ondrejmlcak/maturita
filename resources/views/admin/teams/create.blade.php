@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.teams.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Název týmu</label>
            <input type="text" class="form-control" id="name" name="name" maxlength="20" required>
        </div>
        <div class="mb-3">
            <label for="league_id" class="form-label">Liga</label>
            <select class="form-select" id="league_id" name="league_id" required>
                <option value="">Vyberte ligu</option>
                @foreach ($leagues as $league)
                    <option value="{{ $league->id }}">{{ $league->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Obárzek týmu</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/png, image/jpg, image/jpeg">
            @if ($errors->has('image'))
                <div class="text-danger">{{ $errors->first('image') }}</div>
            @endif
        </div>

        <button type="submit" class="btn btn-success submit-once">Vytvořit</button>
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
