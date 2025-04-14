@extends('layouts.live')

@section('content')
    <h2>Všechny tikety</h2>

    @if ($tickets->isEmpty())
        <p>Zatím jste nevytvořil žádný tiket.</p>
    @else
        @foreach ($tickets as $ticket)
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Vklad: {{ number_format($ticket->stake, 2) }}
                    </div>
                    <div>
                        @php
                            $statusClass = match($ticket->status) {
                                'won' => 'text-success',
                                'lost' => 'text-danger',
                                'pending' => 'text-warning'
                            };
                            $statusText = match($ticket->status) {
                                'won' => 'Výhra',
                                'lost' => 'Prohra',
                                'pending' => 'Čeká na vyřízení'
                            };
                        @endphp
                        <span class="{{ $statusClass }}"><strong>{{ $statusText }}</strong></span>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $totalOdd = $ticket->bets->reduce(function ($carry, $bet) {
                            return $carry * $bet->odd;
                        }, 1);
                    @endphp

                    <div class="mb-2">
                        <strong>Celkový kurz:</strong> {{ number_format($totalOdd, 2) }}
                    </div>
                    <div class="mb-3">
                        <strong>Možná výhra:</strong> {{ number_format($ticket->final_win, 2) }}
                    </div>

                    <ul class="list-group">
                        @foreach ($ticket->bets as $bet)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        {{ $bet->match->home_team ?? 'Neznámý tým' }} -
                                        {{ $bet->match->away_team ?? 'Neznámý tým' }} ⇒ {{ \Carbon\Carbon::parse($bet->match->start_time)->format('d.m.Y H:i') }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $bet->bet_type }} - {{ $bet->odd }}
                                        </small>
                                    </div>
                                    <div class="text-right">
                                        @php
                                            $statuses = [
                                                "" => 'Ještě nezačalo',
                                                "1st" => '1. poločas',
                                                "HalfTime" => 'Poločas',
                                                "2nd" => '2. poločas',
                                                "Ended" => 'Ukončeno'
                                            ];
                                            $matchStatus = $statuses[$bet->match->status] ?? 'Neznámý stav';
                                        @endphp

                                        <span class="badge badge-info">{{ $matchStatus }}</span>

                                        @if($bet->match->score ?? null)
                                            <span class="badge badge-primary">{{ $bet->match->score }}</span>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    @endif
@endsection
