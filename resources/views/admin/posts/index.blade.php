@extends('layouts.admin')

@section('content')
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary submit-once">Vytvořit příspěvek</a>
    <div class="table-responsive">
    <table class="table mt-3">
        <thead>
        <tr>
            <th>Název</th>
            <th>Exkluziv.</th>
            <th>Datum vytvoř.</th>
            <th>Autor</th>
            <th>Akce</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($posts as $post)
            <tr>
                <td>{{ Str::limit($post->title, 30) }}</td>
                <td>{{ $post->exkluzivni }}</td>
                <td>{{ $post->created_at->format('d.m.Y. H:i') }}</td>
                <td>{{ $post->author->name }}</td>
                <td>
                    <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-info btn-sm">Zobrazit</a>
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-primary btn-sm submit-once">Upravit</a>
                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Opravdu chcete smazat tento příspěvek? Tato akce je nevratná!');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Smazat</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
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
