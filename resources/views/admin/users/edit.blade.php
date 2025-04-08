@extends('layouts.admin')

@section('content')
@if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Jméno</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="money">Peníze</label>
                <input type="number" name="money" id="money" class="form-control" min="0" step="0.01" value="{{ old('money', $user->money) }}">
            </div>

            <div class="mb-3">
                <label for="usertype" class="form-label">Role</label>
                <select name="usertype" id="usertype" class="form-select" required>
                    <option value="">Vyberte roli</option>
                    <option value="admin" {{ old('usertype', $user->usertype) == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="editor" {{ old('usertype', $user->usertype) == 'editor' ? 'selected' : '' }}>Editor</option>
                    <option value="user" {{ old('usertype', $user->usertype) == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="password">Nové heslo (nepovinné)</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation">Potvrzení hesla</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary mt-3 submit-once">Uložit změny</button>
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
