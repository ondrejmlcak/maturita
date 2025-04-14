@extends('layouts.live')

@section('content')

    <div class="row">
        @forelse ($matches as $match)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card d-flex flex-column h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $match['league'] ?? 'Neznámá liga' }}</h5>
                        <p class="card-text"><strong>Začátek:</strong> {{ isset($match['start_time']) ? \Carbon\Carbon::parse($match['start_time'])->format('d.m.Y H:i') : 'Neznámý čas' }}</p>
                        <p class="card-text"><strong>Domácí tým:</strong> {{ $match['home_team'] ?? 'Neznámý tým' }}</p>
                        <p class="card-text"><strong>Hostující tým:</strong> {{ $match['away_team'] ?? 'Neznámý tým' }}</p>
                        @if (!empty($match['id']))
                            <a href="{{ route('match.odds', $match['id']) }}" class="btn btn-primary mt-auto">Kurzy</a>
                        @else
                            <span class="text-muted">Nedostupné</span>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">Žádné zápasy nejsou k dispozici.</p>
            </div>
        @endforelse
    </div>

@endsection
