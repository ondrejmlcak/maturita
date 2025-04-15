@extends('layouts.live')

@section('content')
    <style>
        .match-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }


        .card-title {
            font-weight: bold;
        }

        .btn-primary {
            margin-top: auto;
        }
    </style>

    <div class="row">
        @forelse ($matches as $match)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card match-card d-flex flex-column h-100 border-0 shadow-sm rounded">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary">{{ $match['league'] ?? 'Neznámá liga' }}</h5>
                        <p class="card-text mb-1"><strong>Začátek:</strong> {{ isset($match['start_time']) ? \Carbon\Carbon::parse($match['start_time'])->format('d.m.Y H:i') : 'Neznámý čas' }}</p>
                        <p class="card-text mb-1"><strong>Domácí tým:</strong> {{ $match['home_team'] ?? 'Neznámý tým' }}</p>
                        <p class="card-text mb-3"><strong>Hostující tým:</strong> {{ $match['away_team'] ?? 'Neznámý tým' }}</p>

                        @if (!empty($match['id']))
                            <a href="{{ route('match.odds', $match['id']) }}" class="btn btn-primary mt-auto">Kurzy</a>
                        @else
                            <span class="text-muted mt-auto">Nedostupné</span>
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
