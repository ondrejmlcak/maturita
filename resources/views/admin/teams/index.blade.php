@extends('layouts.admin')

@section('content')
    <a href="{{ route('admin.teams.create') }}" class="btn btn-primary submit-once">Vytvořit tým</a>

    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Jméno</th>
            <th>Slug</th>
            <th>Liga</th>
            <th>Akce</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($teams as $team)
            <tr>
                <td>{{ $team->id }}</td>
                <td>{{ $team->name }}</td>
                <td>{{ $team->slug }}</td>
                <td>{{ $team->league->name }}</td>
                <td>
                    <a href="{{ route('admin.teams.edit', $team->id) }}" class="btn btn-sm btn-primary submit-once">Upravit</a>
                    <form action="{{ route('admin.teams.destroy', $team->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Chcete smazat vybraný tým?')">Smazat</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
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
