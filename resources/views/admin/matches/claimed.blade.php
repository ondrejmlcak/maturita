@extends('layouts.admin')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.matches.available') }}" class="btn btn-primary">Dostupné zápasy</a>
        <a href="{{ route('admin.matches.my') }}" class="btn btn-secondary">Moje zabrané zápasy</a>
        <a href="{{ route('admin.matches.claimed') }}" class="btn btn-success">Všechny zabrané zápasy</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Domácí tým</th>
            <th>Hostující tým</th>
            <th>Datum zápasu</th>
            <th>Liga</th>
            <th>Kolo</th>
            <th>Zabral</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($allClaimedMatches as $match)
            <tr>
                <td>{{ $match->homeTeam->name }}</td>
                <td>{{ $match->awayTeam->name }}</td>
                <td>{{ \Carbon\Carbon::parse($match->match_date)->format('d.m.Y H:i') }}</td>
                <td>{{ $match->league->name }}</td>
                <td>{{ $match->round_number }}</td>
                <td>{{ $match->commentator->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
