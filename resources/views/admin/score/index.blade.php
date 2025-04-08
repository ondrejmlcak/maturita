@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.score.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Hledat zápas..." value="{{ request('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary">Hledat</button>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
        <tr>
            <th>Domácí tým</th>
            <th>Hostující tým</th>
            <th>Status</th>
            <th>Minuta</th>
            <th>Skóre</th>
            <th>Datum</th>
            <th>Akce</th>
        </tr>
        </thead>
        <tbody>
        @php
            $statuses = [
                "" => 'Ještě nezačalo',
                "1st" => '1. poločas',
                "HalfTime" => 'Poločas',
                "2nd" => '2. poločas',
                "Ended" => 'Ukončeno'
            ];
        @endphp

        @foreach($score as $match)
            <tr>
                <td>{{ $match->home_team }}</td>
                <td>{{ $match->away_team }}</td>
                <td>{{ $statuses[$match->status] ?? 'Neznámý stav' }}</td>
                <td>{{ $match->minutes }}</td>
                <td>{{ $match->score }}</td>
                <td>{{ \Carbon\Carbon::parse($match->start_time)->format('d.m.Y. H:i') }}</td>
                <td>
                    <a href="{{ route('admin.score.edit', $match->id) }}" class="btn btn-warning btn-sm submit-once">Upravit</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
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
