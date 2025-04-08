@extends('layouts.admin')

@section('content')
        <div class="nav nav-tabs mb-4" id="myTab" role="tablist">
            <a class="nav-item nav-link active" id="comments-tab" data-bs-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="true">Komentáře</a>
            <a class="nav-item nav-link" id="match-data-tab" data-bs-toggle="tab" href="#match-data" role="tab" aria-controls="match-data" aria-selected="false">Úprava zápasu</a>
            <a class="nav-item nav-link" id="timeline-tab" data-bs-toggle="tab" href="#timeline" role="tab" aria-controls="timeline" aria-selected="false">Časová osa</a>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                <form action="{{ route('admin.matches.addComment', $match) }}" method="POST">
                    @csrf
                    <input type="hidden" name="zapas_id" value="{{ $match->id }}">

                    <div class="form-group mb-4">
                        <label for="minute">Minuta:</label>
                        <input type="number" name="minute" id="minute" class="form-control">
                    </div>

                    <div class="form-group mb-4">
                        <label for="event_type">Typ události:</label>
                        <select name="event_type" id="event_type" class="form-control">
                            <option value="goal">Gól</option>
                            <option value="yellow_card">Žlutá karta</option>
                            <option value="red_card">Červená karta</option>
                            <option value="substitution">Střídání</option>
                            <option value="normal" selected>Normální</option>
                            <option value="important">Důležitá</option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label for="description">Popis:</label>
                        <textarea name="description" id="description" class="form-control"></textarea>
                    </div>

                    <div class="form-group mt-4 mb-4">
                        <button id="insertLineup" class="btn btn-secondary">Sestava</button>
                        <button id="insertStats" class="btn btn-secondary">Statistiky</button>
                        <button id="insertStartMatch" class="btn btn-secondary">Začátek utkání</button>
                        <button id="insertEndMatch" class="btn btn-secondary">Konec utkání</button>
                    </div>

                    <button type="submit" class="btn btn-primary mb-4 submit-once">Přidat komentář</button>
                </form>

                <h5 class="mt-4">Přenos:</h5>
                @foreach ($comments->sortByDesc('created_at') as $comment)
                    <div class="comment-item mb-3">
                        @if($comment->minute > 0)
                            <p>{{ $comment->minute }}' {{ $comment->description }}</p>
                        @else
                            <p>{{ $comment->description }}</p>
                        @endif

                        <form action="{{ route('admin.matches.updateComment', ['match' => $match->id, 'comment' => $comment->id]) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group mb-2">
                                <label for="minute">Minuta</label>
                                <input type="number" name="minute" id="minute" class="form-control" value="{{ old('minute', $comment->minute) }}">
                            </div>

                            <div class="form-group mb-2">
                                <label for="event_type">Typ události</label>
                                <select name="event_type" id="event_type" class="form-control">
                                    <option value="goal" {{ old('event_type', $comment->event_type) == 'goal' ? 'selected' : '' }}>Gól</option>
                                    <option value="yellow_card" {{ old('event_type', $comment->event_type) == 'yellow_card' ? 'selected' : '' }}>Žlutá karta</option>
                                    <option value="red_card" {{ old('event_type', $comment->event_type) == 'red_card' ? 'selected' : '' }}>Červená karta</option>
                                    <option value="substitution" {{ old('event_type', $comment->event_type) == 'substitution' ? 'selected' : '' }}>Střídání</option>
                                    <option value="normal" {{ old('event_type', $comment->event_type) == 'normal' ? 'selected' : '' }}>Normální</option>
                                    <option value="important" {{ old('event_type', $comment->event_type) == 'important' ? 'selected' : '' }}>Důležitý</option>
                                </select>
                            </div>

                            <div class="form-group mb-2">
                                <label for="description">Komentář</label>
                                <textarea name="description" id="description" class="form-control">{{ old('description', $comment->description) }}</textarea>
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-primary btn-sm d-flex justify-content-center submit-once">Upravit komentář</button>
                            </div>
                        </form>

                        <form action="{{ route('admin.matches.deleteComment', ['match' => $match->id, 'comment' => $comment->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm submit-once">Smazat komentář</button>
                        </form>
                    </div>
                @endforeach

            </div>
        <script>
            document.getElementById('insertLineup').addEventListener('click', function () {
                const homeLineup = '{{ $match->home_lineup }}';
                const awayLineup = '{{ $match->away_lineup }}';
                const homeSubstitutes = '{{ $match->home_substitutes }}';
                const awaySubstitutes = '{{ $match->away_substitutes }}';
                const referee = '{{$match->referee}}';
                const message = `Sestava:
Domácí: ${homeLineup}
Hosté: ${awayLineup}
Náhradníci domácích: ${homeSubstitutes}
Náhradníci hostů: ${awaySubstitutes}
Rozhodčí: ${referee}`;

                document.getElementById('description').value = message;
            });

            document.getElementById('insertStats').addEventListener('click', function () {
                const statsMessage = 'Statistiky: \n: Střely, fauly, ofsajdy, rohy';
                document.getElementById('description').value = statsMessage;
            });

            document.getElementById('insertStartMatch').addEventListener('click', function () {
                const startMessage = 'Začátek utkání';
                document.getElementById('description').value = startMessage;
                document.getElementById('minute').value = 1;

            });

            document.getElementById('insertEndMatch').addEventListener('click', function () {
                const endMessage = 'Konec utkání';
                document.getElementById('description').value = endMessage;
                document.getElementById('minute').value = 90;

            });
        </script>

            <div class="tab-pane fade" id="match-data" role="tabpanel" aria-labelledby="match-data-tab">
                <form action="{{ route('admin.matches.update', $match) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">
                        <div class="d-flex justify-content-between">
                            <div class="col-md-5">
                                <label for="home_score">Domácí skóre</label>
                                <input type="number" name="home_score" id="home_score" value="{{ old('home_score', $match->home_score) }}" class="form-control" min="0">
                            </div>

                            <div class="col-md-5">
                                <label for="away_score">Hosté skóre</label>
                                <input type="number" name="away_score" id="away_score" value="{{ old('away_score', $match->away_score) }}" class="form-control" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="home_lineup">Základní hráči domácího týmu</label>
                        <textarea name="home_lineup" id="home_lineup" class="form-control" placeholder="Zadejte jména hráčů oddělená čárkami">{{ old('home_lineup', $match->home_lineup) }}</textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="away_lineup">Základní hráči hostujícího týmu</label>
                        <textarea name="away_lineup" id="away_lineup" class="form-control" placeholder="Zadejte jména hráčů oddělená čárkami">{{ old('away_lineup', $match->away_lineup) }}</textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="home_substitutes">Náhradníci domácího týmu</label>
                        <textarea name="home_substitutes" id="home_substitutes" class="form-control" placeholder="Zadejte jména hráčů oddělená čárkami">{{ old('home_substitutes', $match->home_substitutes) }}</textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="away_substitutes">Náhradníci hostujícího týmu</label>
                        <textarea name="away_substitutes" id="away_substitutes" class="form-control" placeholder="Zadejte jména hráčů oddělená čárkami">{{ old('away_substitutes', $match->away_substitutes) }}</textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label for="status">Status zápasu</label>
                        <select name="status" id="status" class="form-control">
                            @foreach($statusOptions as $key => $option)
                                <option value="{{ $key }}" {{ $key == $status ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="stadium_name">Stadion</label>
                        <input type="text" name="stadium_name" id="stadium_name" value="{{ old('stadium_name', $match->stadium) }}" class="form-control">
                    </div>
                    <div class="form-group mb-4">
                        <label for="round_number">Číslo kola</label>
                        <input type="number" name="round_number" id="round_number" value="{{ old('round_number', $match->round_number) }}" class="form-control" min="1">
                    </div>
                    <div class="form-group mb-4">
                        <label for="fan_count">Počet fanoušků</label>
                        <input type="number" name="fan_count" id="fan_count" value="{{ old('fan_count', $match->fans_count) }}" class="form-control" min="0">
                    </div>
                    <div class="form-group mb-4">
                        <label for="referee">Rozhodčí</label>
                        <input type="text" name="referee" id="referee" value="{{ old('referee', $match->referee) }}" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary submit-once">Uložit</button>
                </form>

            </div>
            <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
                <h5>Úprava časové osy</h5>
                <form action="{{ route('admin.matches.addEvent', $match->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="event-minute" class="form-label">Minuta</label>
                        <input type="number" name="minute" id="event-minute" class="form-control" required min="1">
                    </div>
                    <div class="mb-3">
                        <label for="event-team" class="form-label">Tým</label>
                        <select name="team_id" id="event-team" class="form-select" required>
                            @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="event-type" class="form-label">Typ události</label>
                        <select name="event_type" id="event-type" class="form-select" required>
                            @foreach(\App\Models\MatchTimeline::EVENT_TYPES as $key => $type)
                                <option value="{{ $key }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="event-player" class="form-label">Hráč</label>
                        <input type="text" name="player_name" id="event-player" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary submit-once">Uložit</button>
                </form>

                <hr>

                <h5>Existující události</h5>
                <ul class="list-group mb-4">
                    @foreach($events as $event)
                        <li class="list-group-item">
                            <strong>{{ $event->minute }}. minuta</strong>
                            - {{ $event->team->name }} -
                            {{ \App\Models\MatchTimeline::EVENT_TYPES[$event->event_type] ?? $event->event_type }}
                            ({{ $event->player_name }})
                            <form action="{{ route('admin.matches.deleteEvent', ['match' => $match->id, 'event' => $event->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm submit-once">Smazat</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
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
