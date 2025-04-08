@extends('layouts.profile')

@section('content')
    <h2 class="mb-4">Upravit profil</h2>

    <form action="{{ route('profile.update') }}" method="POST" class="mb-4">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="name" class="form-label">Jméno</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
        </div>

        <button type="submit" class="btn btn-primary submit-once">Uložit změny</button>
    </form>

    <h3 class="mb-4">Změnit heslo</h3>
    <form method="POST" action="{{ route('profile.updatePassword') }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="current_password" class="form-label">Aktuální heslo</label>
            <input type="password" id="current_password" name="current_password" class="form-control" required>
            @error('current_password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label">Nové heslo</label>
            <input type="password" id="new_password" name="new_password" class="form-control" required>
            @error('new_password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Potvrzení nového hesla</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary submit-once">Změnit heslo</button>
    </form>

    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3">Zpět na dashboard</a>

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
