@extends('layouts.admin')

@section('content')
    <form action="{{ route('admin.score.update', $match->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                @php
                // Přepiše si status do lepsiho provedeni
                    $statuses = [
                        "" => 'Ještě nezačalo',
                        "1st" => '1. poločas',
                        "HalfTime" => 'Poločas',
                        "2nd" => '2. poločas',
                        "Ended" => 'Ukončeno'
                    ];
                @endphp

                @foreach($statuses as $key => $label)
                    <option value="{{ $key }}" {{ $match->status == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Minuta</label>
            <input type="text" name="minutes" value="{{ $match->minutes }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Skóre</label>
            <input type="text" name="score" value="{{ $match->score }}" class="form-control">
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-warning submit-once">Upravit</button>
            <a href="{{ route('admin.score.index') }}" class="btn btn-secondary">Zpět</a>
        </div>
    </form>
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
