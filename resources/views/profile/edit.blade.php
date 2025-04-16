@extends('layouts.profile')

@section('content')
    <h2 class="mb-4" style="color: #6c757d;">Upravit profil</h2>

    <form action="{{ route('profile.update') }}" method="POST" class="mb-4">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="name" class="form-label" style="color: #6c757d;">Jméno</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required style="background-color: #f1f3f5; color: #495057;">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label" style="color: #6c757d;">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required style="background-color: #f1f3f5; color: #495057;">
        </div>

        <button type="submit" class="btn btn-secondary submit-once" style="background-color: #6c757d; border-color: #6c757d;">Uložit změny</button>
    </form>

    <h3 class="mb-4" style="color: #6c757d;">Změnit heslo</h3>
    <form method="POST" action="{{ route('profile.updatePassword') }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="current_password" class="form-label" style="color: #6c757d;">Aktuální heslo</label>
            <input type="password" id="current_password" name="current_password" class="form-control" required style="background-color: #f1f3f5; color: #495057;">
            @error('current_password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="new_password" class="form-label" style="color: #6c757d;">Nové heslo</label>
            <input type="password" id="new_password" name="new_password" class="form-control" required style="background-color: #f1f3f5; color: #495057;">
            @error('new_password')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label" style="color: #6c757d;">Potvrzení nového hesla</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required style="background-color: #f1f3f5; color: #495057;">
        </div>

        <button type="submit" class="btn btn-secondary submit-once" style="background-color: #6c757d; border-color: #6c757d;">Změnit heslo</button>
    </form>

    <a href="{{ route('dashboard') }}" class="btn btn-secondary mt-3" style="background-color: #6c757d; border-color: #6c757d;">Zpět na dashboard</a>

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
