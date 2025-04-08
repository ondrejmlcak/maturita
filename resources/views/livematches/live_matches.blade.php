@extends('layouts.live')

@section('content')

    <table class="table">
        <thead>
        <tr>
            <th>Liga</th>
            <th>Domácí tým</th>
            <th>Hostující tým</th>
            <th>Stav</th>
            <th>Začátek</th>
            <th>Detail</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($matches as $match)
            <tr>
                <td>{{ $match['league'] ?? 'Neznámá liga' }}</td>
                <td>{{ $match['home_team'] ?? 'Neznámý tým' }}</td>
                <td>{{ $match['away_team'] ?? 'Neznámý tým' }}</td>
                <td>
                    @php
                        $periodMap = [
                            '-' => 'Před zápasem',
                            '0' => 'Začíná',
                            '1' => '1. poločas',
                            '2' => 'Poločas',
                            '3' => '2. poločas',
                            '255' => 'Zápas ukončen'
                        ];
                        $periodID = (string) ($match['periodID'] ?? '-');
                        $status = $periodMap[$periodID] ?? 'Neznámý stav';
                    @endphp
                    {{ $status }}
                </td>
                <td>{{ isset($match['start_time']) ? \Carbon\Carbon::parse($match['start_time'])->format('d.m.Y H:i') : 'Neznámý čas' }}</td>
                <td>
                    @if (!empty($match['id']))
                        <a href="{{ route('match.odds', $match['id']) }}" class="btn btn-primary">Detail</a>
                    @else
                        <span class="text-muted">Nedostupné</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Žádné zápasy nejsou k dispozici.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    </div>

@endsection
