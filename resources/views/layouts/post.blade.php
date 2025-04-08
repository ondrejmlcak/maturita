<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(Route::currentRouteName() == 'posts.index')
            TipAndGo
        @elseif(Route::currentRouteName() == 'posts.showByLeague' && isset($league) && !empty($league->name))
            {{ $league->name }} - TipAndGo
        @elseif(Route::currentRouteName() == 'posts.showByTeam' && isset($team) && !empty($team->name))
            {{ $team->name }} - {{ $league->name }} - TipAndGo
        @elseif(isset($post) && !empty($post->title))
            {{ $post->title }} - TipAndGo
        @elseif(request('query'))
            Výsledky vyhledávání pro: "{{ request('query') }}" - TipAndGo
        @else
            TipAndGo
        @endif
    </title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        .embed-responsive {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .embed-responsive-item {
            width: 100%;
            height: 100%;
        }

        blockquote.twitter-tweet {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 auto;
        }

        .twitter-tweet iframe {
            width: 100% !important;
            max-width: 100% !important;
        }


        .post-card {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 15px;
            font-size: 1rem;
            overflow: hidden;
        }

        .post-card-image {
            width: 250px;
            height: 150px;
            object-fit: cover;
            margin-right: 15px;
            border-radius: 5px;
            flex-shrink: 0;
        }

        .post-text {
            flex: 1;
            max-width: calc(100% - 250px);
        }

        @media (max-width: 768px) {
            .post-card {
                flex-direction: column;
                font-size: 0.85rem;
                padding: 10px;
            }

            .post-card-image {
                width: 100%;
                height: 200px;
                margin-right: 0;
                margin-bottom: 10px;
            }

            .post-text {
                font-size: 0.85rem;
                max-width: 100%;
            }
        }

        .post-card h2 a {
            text-decoration: none;
            color: #333;
        }

        .post-card h2 a:hover {
            color: #007bff;
        }

        .post-card p {
            color: #555;
        }

        .navbar-custom {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }

        .navbar-custom .navbar-nav {
            width: 100%;
            justify-content: space-between;
        }

        .navbar-custom .navbar-nav .nav-item {
            margin-left: 10px;
        }

        .search-bar {
            max-width: 300px;
            width: 100%;
        }


        .search-result-header {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top w-100">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand" href="{{ route('dashboard') }}">TipAndGo</a>

        <form class="form-inline my-2 my-lg-0" method="GET" action="{{ route('posts.search') . '/'}}">
            <input class="form-control search-bar mr-3" type="search" maxlength="20" placeholder="Hledat články..." aria-label="Search" name="query" value="{{ request('query') }}" required>
        </form>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto d-flex align-items-center">
                <li class="nav-item mr-3">
                    <a class="nav-link" href="{{ route('posts.index') . '/'}}">Všechny ligy</a>
                </li>
                @foreach($leagues as $league)
                    <li class="nav-item mr-3">
                        <a class="nav-link" href="{{ route('posts.showByLeague', $league->slug) . '/' }}">{{ $league->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5 pt-5 pl-5 pr-5">
        <div class="content-area pl-5 pr-5">
        @yield('content')
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
