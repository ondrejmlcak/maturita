@extends('layouts.admin')

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
    <div class="container">
        <div class="card mb-3">
            <div class="card-header">Informace o tiketu</div>
            <div class="card-body">
                <p><strong>ID tiketu:</strong> {{ $ticket->id }}</p>
                <p><strong>Uživatel:</strong> {{ $ticket->user->name ?? 'Neznámý' }}</p>
                <p><strong>Vsazená částka:</strong> {{ number_format($ticket->stake, 2) }}</p>
                <p><strong>Možná výhra:</strong> {{ number_format($ticket->final_win, 2) }}</p>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Sázkové příležitosti</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Liga</th>
                                <th>Domácí</th>
                                <th>Hosté</th>
                                <th>Datum</th>
                                <th>Status</th>
                                <!--<th>Minuta</th>-->
                                <th>Skóre</th>
                                <th>Typ sázky</th>
                                <th>Kurz</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ticket->bets as $bet)
                                <tr>
                                    <td>{{ $bet->match->league ?? 'Neznámá' }}</td>
                                    <td>{{ $bet->match->home_team ?? 'Neznámý' }}</td>
                                    <td>{{ $bet->match->away_team ?? 'Neznámý' }}</td>
                                    <td> {{\Carbon\Carbon::parse($bet->match->start_time)->format('d.m.Y H:i')}}</td>
                                    <td>
                                        @php
                                            $statuses = [
                                                '' => 'Ještě nezačalo',
                                                '1st' => '1. poločas',
                                                'HalfTime' => 'Poločas',
                                                '2nd' => '2. poločas',
                                                'Ended' => 'Ukončeno'
                                            ];
                                            $matchStatus = $statuses[$bet->match->status] ?? 'Neznámý stav';
                                        @endphp
                                        {{ $matchStatus }}
                                    </td>
                                   <!-- <td>{{ $bet->match->minutes ?? 'Neznámý' }}</td> -->
                                    <td>{{ $bet->match->score ?? 'N/A' }}</td>
                                    <td>{{ $bet->bet_type }}</td>
                                    <td>{{ $bet->odd }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group">
                <label for="status">Stav tiketu:</label>
                <select name="status" id="status" class="form-control">
                    <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Čeká na schválení</option>
                    <option value="won" {{ $ticket->status == 'won' ? 'selected' : '' }}>Výherní</option>
                    <option value="lost" {{ $ticket->status == 'lost' ? 'selected' : '' }}>Proherní</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success mt-3 mb-3 submit-once">Uložit změny</button>
        </form>
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
