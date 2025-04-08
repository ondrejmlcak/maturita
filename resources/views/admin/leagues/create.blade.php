@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.leagues.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Název ligy</label>
            <input type="text" class="form-control" id="name" name="name" maxlength="20" required>
        </div>
        <button type="submit" class="btn btn-success submit-once">Vytvořit</button>
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
