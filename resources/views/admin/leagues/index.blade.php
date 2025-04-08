@extends('layouts.admin')

@section('content')
    <a href="{{ route('admin.leagues.create') }}" class="btn btn-primary submit-once">Vytvořit ligu</a>

    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Jméno</th>
            <th>Slug</th>
            <th>Akce</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($leagues as $league)
            <tr>
                <td>{{ $league->id }}</td>
                <td>{{ $league->name }}</td>
                <td>{{ $league->slug }}</td>
                <td>
                    <a href="{{ route('admin.leagues.edit', $league->id) }}" class="btn btn-sm btn-primary submit-once">Upravit</a>
                    <form action="{{ route('admin.leagues.destroy', $league->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Chcete smazat vybranou ligu?')">Smazat</button>
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
