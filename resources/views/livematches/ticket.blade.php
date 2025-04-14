@extends('layouts.live')

@section('content')
    <div class="container">
        <h1>Váš tiket</h1>

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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $totalOdd = 1;
        @endphp

        @if (session('ticket') && count(session('ticket')) > 0)
            @php
                foreach (session('ticket') as $index => $bet) {
                    $totalOdd *= $bet['odd'];
                }
            @endphp

            <table class="table">
                <thead>
                <tr>
                    <th>Domácí tým</th>
                    <th>Hostující tým</th>
                    <th>Typ sázky</th>
                    <th>Kurz</th>
                    <th>Akce</th>
                </tr>
                </thead>
                <tbody>
                @foreach (session('ticket') as $index => $bet)
                    <tr>
                        <td>{{ $bet['home_team'] ?? 'Neznámý tým' }}</td>
                        <td>{{ $bet['away_team'] ?? 'Neznámý tým' }}</td>
                        <td>{{ $bet['bet_type'] }}</td>
                        <td>{{ $bet['odd'] }}</td>
                        <td>
                            <form action="{{ route('ticket.remove', ['index' => $index]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i> Odebrat
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <form action="{{ route('ticket.place') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="amount">Sázka</label>
                    <input type="number" name="amount" id="amount" class="form-control" min="5" required oninput="calculateWin()">
                </div>

                <p><strong>Celkový kurz:</strong> {{ number_format($totalOdd, 2) }}</p>
                <p><strong>Možná výhra:</strong> <span id="potentialWin">0</span></p>

                <button type="submit" class="btn btn-success submit-once">Podat tiket</button>
            </form>
        @else
            <p>Na tiketu se momentálně nic nenachází...</p>
        @endif
    </div>

    <script>
        function calculateWin() {
            let stake = document.getElementById('amount').value;
            let totalOdd = {{ $totalOdd }};
            let potentialWin = (stake * totalOdd).toFixed(2);
            document.getElementById('potentialWin').textContent = potentialWin;
        }
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
