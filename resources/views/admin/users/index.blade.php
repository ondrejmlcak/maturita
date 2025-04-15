@extends('layouts.admin')

@section('content')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary submit-once">Vytvoř uživatele</a>
    <div class="table-responsive">
    <table class="table mt-3">
            <thead>
            <tr>
                <th scope="col">Jméno</th>
                <th scope="col">Email</th>
                <th scope="col">Peníze</th>
                <th scope="col">Role</th>
                <th scope="col">Akce</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->money }}</td>
                    <td>{{ $user->usertype }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary submit-once">Upravit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Smazat</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.querySelectorAll('.delete-form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!confirm('Opravdu chcete smazat tohoto uživatele?')) {
                    event.preventDefault();
                }
            });
        });
    </script>
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
