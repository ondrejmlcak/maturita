@extends('layouts.admin')

@section('content')

        <form action="{{ route('admin.matches.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="home_team">Domácí tým</label>
                <select name="home_team_id" id="home_team_id" class="form-control" required>
                    <option value="">Vyberte domácí tým</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="away_team">Hostující tým</label>
                <select name="away_team_id" id="away_team_id" class="form-control" required>
                    <option value="">Vyberte hostující tým</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="league_id">Liga</label>
                <select name="league_id" id="league_id" class="form-control" required>
                    <option value="">Vyberte ligu</option>
                    @foreach ($leagues as $league)
                        <option value="{{ $league->id }}">{{ $league->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="round">Kolo</label>
                <input type="number" name="round_number" id="round_number" class="form-control" min="1" required>
            </div>


        <div class="form-group mb-3">
            <label for="match_date">Datum a čas zápasu</label>
            <input type="datetime-local" name="match_date" id="match_date" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="stadium_name">Stadion</label>
            <input type="text" name="stadium_name" id="stadium_name" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary mb-3 submit-once">Vytvořit zápas</button>
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
