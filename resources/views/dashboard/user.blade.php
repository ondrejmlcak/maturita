@extends('layouts.test')

@section('content')
    <h4 class="mb-3">Vaše poslední 3 tikety</h4>

    @if ($latestTickets->isEmpty())
        <p class="text-muted">Zatím jste nevytvořil žádný tiket.</p>
    @else
        <div class="row">
            @foreach ($latestTickets as $ticket)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center py-2 px-3">
                            <div>Vklad: {{ number_format($ticket->stake, 2) }}</div>
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

                        <div class="card-body p-3">
                            @php
                                $totalOdd = $ticket->bets->reduce(fn($carry, $bet) => $carry * $bet->odd, 1);
                            @endphp

                            <div class="mb-2"><strong>Počet sázek:</strong> {{ $ticket->bets->count() }}</div>
                            <div class="mb-2"><strong>Celkový kurz:</strong> {{ number_format($totalOdd, 2) }}</div>
                            <div><strong>Možná výhra:</strong> {{ number_format($ticket->final_win, 2) }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
