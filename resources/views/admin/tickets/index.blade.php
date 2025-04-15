@extends('layouts.admin')

@section('content')

    <div class="table-responsive">
    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Uživatel</th>
            <th>Vsazeno</th>
            <th>Možná výhra</th>
            <th>Status</th>
            <th>Akce</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->user->name ?? 'Neznámý' }}</td>
                <td>{{ number_format($ticket->stake, 2) }}</td>
                <td>{{ $ticket->final_win ? number_format($ticket->final_win, 2) : '-' }}</td>
                <td>
                    @if ($ticket->status === 'won')
                        ✅
                    @elseif ($ticket->status === 'lost')
                        ❌
                    @else
                        ⏳
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn btn-warning btn-sm submit-once">Upravit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
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
