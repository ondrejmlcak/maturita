@extends('layouts.match')

@section('content')
    <div class="container mt-5 pt-5 pl-5 pr-5">
        <div class="date-navigation">
            <a href="{{ route('matches.index', ['date' => $prevDate, 'league' => request('league')]) }}">Předchozí den</a>
            <span>{{ \Carbon\Carbon::parse($currentDate)->format('d.m.Y') }}</span>
            <a href="{{ route('matches.index', ['date' => $nextDate, 'league' => request('league')]) }}">Další den</a>
        </div>

        <div class="content-area">
            @if($leagueId)
                <p>Zobrazit zápasy z ligy: <strong>{{ $leagues->find($leagueId)->name }}</strong></p>
            @endif

        @if($matches->isEmpty())
                <p>Pro tento den nejsou žádné zápasy.</p>
            @else
                @foreach($matches as $match)
                    <div class="match-card">
                        <h2>{{ $match->homeTeam->name }} {{ $match->home_score }}:{{ $match->away_score }} {{ $match->awayTeam->name }}</h2>
                        <p>Čas: {{ \Carbon\Carbon::parse($match->match_date)->format('H:i') }}</p>
                        @php
                            $lastComment = $match->comments()->orderByDesc('minute')->first();
                        @endphp
                        @if($lastComment)
                            <p>Poslední akce: {{ $lastComment->minute }}' {{ $lastComment->description }}</p>
                        @else
                            <p>Žádný komentář</p>
                        @endif
                        <a href="{{ route('matches.show', $match->id) }}" class="btn btn-primary">Zobrazit detail</a>
                    </div>
                @endforeach

            @endif
        </div>
    </div>
@endsection
