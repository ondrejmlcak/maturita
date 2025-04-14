@extends('layouts.post')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Domů</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('posts.showByLeague', $post->league->slug) . '/'}}">{{ $post->league->name }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
        </ol>
    </nav>

    @if($post->exkluzivni === 'ano')
        <div class="d-flex align-items-center mb-3">
            <i class="fa fa-fire text-danger me-2 mr-2"></i>
            <span class="badge bg-danger text-white">Exkluzivní</span>
        </div>
    @endif

    <h1>{{ $post->title }}</h1>
    <p>
        Vytvořeno dne {{ \Carbon\Carbon::parse($post->created_at)->format('d. m. Y') }},
        Autor: <a href="{{ route('posts.byAuthor', ['id' => $post->user_id]) }}">{{ $post->author->name }}</a>
    </p>


    @if($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="img-fluid post-image">
    @endif

    <p>{{ $post->lead_paragraph }}</p>


    <p>{!! $post->description !!}</p>

    <h4>Tagy:</h4>
    <ul class="list-inline">
        @foreach($post->teams as $team)
            <li class="list-inline-item">
                <a href="{{ route('posts.showByTeam', [$post->league->slug, $team->slug]) . '/'}}"
                   class="btn btn-outline-primary btn-sm">
                    {{ $team->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endsection
