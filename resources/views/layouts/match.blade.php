<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Textové přenosy
    </title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <style>
        @media (min-width: 992px) {
            .container .content-wrapper {
                padding-right: 5rem;
                padding-left: 5rem;
            }
        }

        .comment {
            margin-bottom: 0;
            padding: 0;
        }

        .comment-minute {
            margin-right: 0.5rem;
            padding-right: 0;
        }

        .comment-text {
            margin-left: 0;
            padding-left: 0;
        }


        .lineup-container,
        .substitutes-container {
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 15px;
        }

        .lineup-container ul,
        .substitutes-container ul {
            list-style-type: none;
            padding-left: 0;
        }

        .match-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 20px;
        }

        .match-card h2 {
            margin-bottom: 10px;
        }

        .match-card p {
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

        .date-navigation {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .date-navigation a {
            margin: 0 10px;
            text-decoration: none;
            color: #007bff;
        }

        .date-navigation a:hover {
            text-decoration: underline;
        }

        .content-area {
            padding: 20px;
        }

        .lineups-container {
            display: flex;
            justify-content: space-between;
            gap: 30px;
        }

        .lineup {
            flex: 1;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .home-lineup {
            background-color: #f0f0f0;
        }

        .away-lineup {
            background-color: #f0f0f0;
        }

        .lineup h4 {
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .lineup ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .lineup li {
            padding: 5px 0;
            font-weight: normal;
            font-size: 20px;
        }

        .timeline-container {
            width: 100%;
            padding: 20px;
        }

        .timeline {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .timeline-item {
            display: flex;
            margin-bottom: 20px;
            align-items: center;
        }

        .timeline-item.home {
            flex-direction: row;
        }

        .timeline-item.away {
            flex-direction: row-reverse;
        }

        .timeline-content {
            display: flex;
            align-items: center;
            margin: 0 10px;
        }

        .event-icon {
            font-size: 1.5rem;
            margin-right: 10px;
        }

        .event-minute {
            font-weight: bold;
            margin-right: 5px;
        }

        .event-player {
            font-size: 1rem;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top w-100">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand" href="{{ route('dashboard') }}">TipAndGo</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto d-flex align-items-center">
                <li class="nav-item mr-3">
                    <a class="nav-link" href="{{ route('matches.index') }}">Všechny zápasy</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="leagueDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ligy
                    </a>
                    <div class="dropdown-menu" aria-labelledby="leagueDropdown">
                        @foreach($leagues as $league)
                            <a class="dropdown-item" href="{{ route('matches.index', ['league' => $league->id]) }}">{{ $league->name }}</a>
                        @endforeach
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="content-area">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
