@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.matches.index') }}" class="btn btn-primary">Všechny zápasy</a>
        <a href="{{ route('admin.matches.my') }}" class="btn btn-secondary">Moje zabrané zápasy</a>
        <a href="{{ route('admin.matches.claimed') }}" class="btn btn-success">Všechny zabrané zápasy</a>
    </div>

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
            @foreach ($matches as $match)
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
                            <button type="submit" class="btn btn-primary">Zabrat</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
