@extends('layouts.post')

@section('content')
    @if(isset($league) && !empty($league->name) && Route::currentRouteName() == 'posts.showByLeague')
        <div class="team-tag-header mb-4">
            <h2>Zobrazit články pro ligu: "{{ $league->name }}"</h2>
        </div>
    @elseif(Route::currentRouteName() == 'posts.showByTeam' && isset($team) && !empty($team->name))
        <div class="team-tag-header">
            <h2>Zobrazit články pro tým: "{{ $team->name }}"</h2>
        </div>
    @endif
    @if(request('query'))
        <div class="search-result-header">
            <h2>Výsledky vyhledávání pro: "{{ request('query') }}"</h2>
        </div>
    @endif

    <ul class="list-unstyled">
        @foreach ($posts as $post)
            <li class="mb-4">
                <div class="post-card d-flex flex-column flex-md-row align-items-start align-items-md-center">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                             class="post-card-image img-fluid">
                    @endif

                    <div class="post-text ml-md-3 mt-2 mt-md-0">
                        <h2>
                            <a href="{{ route('posts.show', ['slug' => $post->slug]) . '/' }}">{{ $post->title }}</a>
                        </h2>

                        <p>
                            <i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($post->created_at)->format('d. m. Y H:i') }}
                        </p>

                        <p>{{ Str::limit($post->lead_paragraph, 100) }}</p>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endsection
