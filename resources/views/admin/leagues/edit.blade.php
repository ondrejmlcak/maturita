@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.leagues.update', $league->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Název ligy</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $league->name }}" maxlength="20" required>
        </div>
        <button type="submit" class="btn btn-warning submit-once">Upravit</button>
        <a href="{{ route('admin.leagues.index') }}" class="btn btn-secondary">Zpět</a>
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
