@extends('layouts.match')

@section('content')
    <div class="container mt-5">
        <div class="content-wrapper">
            <div class="match-header d-flex align-items-center justify-content-between text-center">
                <div class="team d-flex flex-column align-items-center">
                    <img src="{{ asset('storage/' . $match->homeTeam->image) }}" alt="{{ $match->homeTeam->name }}" width="100">
                    <h3 class="team-name">{{ $match->homeTeam->name }}</h3>
                </div>
                <div class="score">
                    <h1 class="mb-0">{{ $match->home_score }}-{{ $match->away_score }}</h1>
                </div>
                <div class="team d-flex flex-column align-items-center">
                    <img src="{{ asset('storage/' . $match->awayTeam->image) }}" alt="{{ $match->awayTeam->name }}" width="100">
                    <h3 class="team-name">{{ $match->awayTeam->name }}</h3>
                </div>
            </div>
            <p class="text-center">
                {{ \Carbon\Carbon::parse($match->match_date)->format('d.m.Y H:i') }}
                @if ($match->status === 'before')
                    <span class="badge bg-success">Před zápasem</span>
                @elseif ($match->status === '1st' || $match->status === '2nd' || $match->status === '1st_extra' || $match->status === '2nd_extra')
                    <span class="badge bg-primary">
        @if ($match->status === '1st') První poločas
                        @elseif ($match->status === '2nd') Druhý poločas
                        @elseif ($match->status === '1st_extra') První prodloužení
                        @elseif ($match->status === '2nd_extra') Druhé prodloužení
                        @endif
    </span>
                @elseif ($match->status === 'half_time' || $match->status === 'after_90' || $match->status === 'after_105')
                    <span class="badge bg-info">
        @if ($match->status === 'half_time') Poločas
                        @elseif ($match->status === 'after_90') Po 90 minutách
                        @elseif ($match->status === 'after_105') Po 105 minutách
                        @endif
    </span>
                @elseif ($match->status === 'full_time')
                    <span class="badge bg-secondary">Konec zápasu</span>
                @elseif ($match->status === 'penalty')
                    <span class="badge bg-danger">Penaltový rozstřel</span>
                @elseif ($match->status === 'suspended')
                    <span class="badge bg-danger">Nedohráno</span>
                @else
                    <span class="badge bg-warning">Neznámý stav</span>
                @endif


                | {{ $match->league->name }} | {{ $match->round_number }}. kolo
            </p>
            <ul class="nav nav-tabs mt-4" id="matchTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="comments-tab" onclick="showTab('comments')">📢 Přenos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="lineups-tab" onclick="showTab('lineups')">👥 Sestavy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="info-tab" onclick="showTab('info')">⚽ Informace</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="timeline-tab" onclick="showTab('timeline')">⏱️ Časová osa</a>
                </li>
            </ul>
            <div class="tab-content mt-3">
                <div id="comments" class="tab-pane fade show active">
                    <h3>Přenos</h3>
                    @foreach ($comments as $comment)
                        <div class="comment mb-3 d-flex border p-2">
                            @if ($comment->minute > 0)
                            <div class="comment-minute me-3">
                                <small class="text-muted">{{ $comment->minute }}'</small>
                            </div>
                            @endif
                            <div class="comment-text">
                                <p>{{ $comment->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div id="lineups" class="tab-pane fade">
                    <div class="lineups-container d-flex justify-content-between">
                        <div class="lineup home-lineup">
                            <h4>Sestava domácích</h4>
                            <ul>
                                @foreach ($homeLineup as $player)
                                    <li>{{ $player }}</li>
                                @endforeach
                            </ul>
                            <h5>Náhradníci:</h5>
                            <ul>
                                @foreach ($homeSubstitutes as $substitute)
                                    <li>{{ $substitute }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="lineup away-lineup">
                            <h4>Sestava hostů</h4>
                            <ul>
                                @foreach ($awayLineup as $player)
                                    <li>{{ $player }}</li>
                                @endforeach
                            </ul>
                            <h5>Náhradníci:</h5>
                            <ul>
                                @foreach ($awaySubstitutes as $substitute)
                                    <li>{{ $substitute }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="info" class="tab-pane fade">
                    <p><strong>Rozhodčí:</strong> {{ $match->referee }}</p>
                    <p><strong>Stadion:</strong> {{ $match->stadium }}</p>
                    <p><strong>Počet fanoušků:</strong> {{ $match->fans_count }}</p>
                </div>
                <div id="timeline" class="tab-pane fade">
                    <h3>Časová osa</h3>
                    <div class="timeline-container">
                        <div class="timeline">
                            @php
                                function getEventEmoji($eventType) {
                                    switch($eventType) {
                                        case 'goal':
                                            return '⚽';
                                        case 'penalty':
                                            return '🅿️';
                                        case 'yellow_card':
                                            return '🟨';
                                        case 'red_card':
                                            return '🟥';
                                        case 'substitution':
                                            return '🔄';
                                        case 'penalty_miss':
                                            return '❌';
                                        case 'own_goal':
                                            return '🥅';
                                        case 'assist':
                                            return '🤝';
                                        default:
                                            return '❓';
                                    }
                                }
                            @endphp
                            @foreach ($events as $event)
                                <div class="timeline-item">
                                    <div class="timeline-content">
                                        <span class="event-icon">{{ getEventEmoji($event->event_type) }}</span>
                                        <span class="event-minute">{{ $event->minute }}'</span>
                                        <span class="event-player">
                                            {{ $event->player_name }}
                                            <span class="text-muted">({{ $event->team_id == $event->match->homeTeam->id ? $event->match->homeTeam->name : $event->match->awayTeam->name }})</span>
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabId) {
            document.getElementById('comments').classList.remove('show', 'active');
            document.getElementById('lineups').classList.remove('show', 'active');
            document.getElementById('info').classList.remove('show', 'active');
            document.getElementById('timeline').classList.remove('show', 'active');
            document.getElementById(tabId).classList.add('show', 'active');
            document.getElementById('comments-tab').classList.remove('active');
            document.getElementById('lineups-tab').classList.remove('active');
            document.getElementById('info-tab').classList.remove('active');
            document.getElementById('timeline-tab').classList.remove('active');
            document.getElementById(tabId + '-tab').classList.add('active');
        }
    </script>
@endsection
