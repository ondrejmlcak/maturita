@extends('layouts.live')

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

        @if (!empty($match_info))
            <div class="match-info">
                <h1>{{ $match_info['home_team'] }} vs {{ $match_info['away_team'] }}</h1>
                <p><strong>Liga:</strong> {{ $match_info['league'] }}</p>
                <p><strong>Čas:</strong> {{ $match_info['start_time'] }}</p>
                <p><strong>Výsledek:</strong> {{ $match_info['score'] }}</p>
            </div>
        @endif

        @if (!empty($odds))
            <table class="table">
                <thead>
                <tr>
                    <th>Typ sázky</th>
                    <th>Kurz</th>
                    <th>Akce</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($odds as $betType => $odd)
                    <tr>
                        <td>{{ $odd['bet_type'] }}</td>
                        <td>{{ $odd['odd'] }}</td>
                        <td>
                            <form action="{{ route('ticket.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="match_id" value="{{ $match_info['id'] ?? '' }}">
                                <input type="hidden" name="league" value="{{ $match_info['league'] ?? 'Neznámá liga' }}">
                                <input type="hidden" name="home_team" value="{{ $match_info['home_team'] ?? 'Neznámý tým' }}">
                                <input type="hidden" name="away_team" value="{{ $match_info['away_team'] ?? 'Neznámý tým' }}">
                                <input type="hidden" name="bet_type" value="{{ $odd['bet_type'] }}">
                                <input type="hidden" name="odd" value="{{ $odd['odd'] }}">
                                <button type="submit" class="btn btn-success">Přidat na tiket</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Kurzy pro tento zápas nejsou dostupné.</p>
        @endif
@endsection
