@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.matches.available') }}" class="btn btn-primary">Dostupné zápasy</a>
        <a href="{{ route('admin.matches.my') }}" class="btn btn-secondary">Mnou zabrané zápasy</a>
        <a href="{{ route('admin.matches.claimed') }}" class="btn btn-success">Všechny zabrané zápasy</a>
        @if(auth()->user()->usertype !== 'editor')
            <a href="{{ route('admin.matches.create') }}" class="btn btn-warning submit-once">Vytvoř zápas</a>
        @endif

    </div>

    <div class="mb-4">
        @if($noMatchesAvailable)
            <table class="table">
            <thead>
            <tr>
                <th>Domácí tým</th>
                <th>Hostující tým</th>
                <th>Datum zápasu</th>
                <th>Liga</th>
                <th>Kolo</th>
                <th>Akce</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            </table>
            <p>Žádný zápas není k dispozici.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Domácí tým</th>
                    <th>Hostující tým</th>
                    <th>Datum zápasu</th>
                    <th>Liga</th>
                    <th>Kolo</th>
                    <th>Akce</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($matches as $match)
                    <tr>
                        <td>{{ $match->homeTeam->name }}</td>
                        <td>{{ $match->awayTeam->name }}</td>
                        @if($match->match_date)
                            <td>{{ \Carbon\Carbon::parse($match->match_date)->format('d.m.Y H:i') }}</td>
                        @else
                            <td>Datum není k dispozici</td>
                        @endif
                        <td>{{ $match->league->name }}</td>
                        <td>{{ $match->round_number }}</td>
                        <td>
                            <form action="{{ route('admin.matches.claim', $match->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary submit-once">Zabrat</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
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
