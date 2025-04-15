@extends('layouts.admin')

@section('content')
    @if(Route::is('admin.dashboard'))
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="dashboard-card">
                <h3 class="dashboard-title">
                    Posledních 5 článků
                </h3>
                <ul>
                    @forelse($latestPosts as $post)
                        <li class="dashboard-list-item">
                            <div class="flex justify-between items-center">
                                <a href="{{ route('posts.show', $post->slug) }}" class="dashboard-link">
                                    {{ $post->title }}
                                </a>
                                <span class="dashboard-date">{{ $post->created_at->format('d.m.Y') }}</span>
                            </div>
                        </li>
                    @empty
                        <li class="dashboard-empty">Žádné články k zobrazení.</li>
                    @endforelse
                </ul>
            </div>

            <div class="dashboard-card">
                <h3 class="dashboard-title">
                    Poslední 4 zápasy
                </h3>
                <ul>
                    @forelse($latestMatches as $match)
                        <li class="dashboard-list-item">
                            <div class="flex flex-col">
                                <a href="{{ route('matches.show', $match->id) }}" class="dashboard-link">
                                    {{ $match->homeTeam->name ?? 'Neznámý tým' }}
                                    vs
                                    {{ $match->awayTeam->name ?? 'Neznámý tým' }}
                                </a>
                                <span class="dashboard-date">
                                    {{ $match->match_date ? \Carbon\Carbon::parse($match->match_date)->format('d.m.Y H:i') : '-' }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="dashboard-empty">Žádné zápasy k zobrazení.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    @endif
@endsection
