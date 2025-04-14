<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurzy - TipAndGo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top w-100">
    <div class="container d-flex justify-content-between">
        <a class="navbar-brand" href="{{ route('dashboard') }}">TipAndGo</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="ticketsDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Tikety
                    </a>
                    <div class="dropdown-menu" aria-labelledby="ticketsDropdown">
                        <a class="dropdown-item" href="{{ route('ticket.all') }}">Vaše tikety</a>
                        <a class="dropdown-item" href="{{ route('ticket.view') }}">Tvorba tiketu</a>
                        <div class="dropdown-divider"></div>
                        <span class="dropdown-item-text">Konto: {{ number_format(Auth::user()->money, 2) }}</span>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('live/matches') ? 'active' : '' }}" href="{{ route('live.matches') }}">Všechny zápasy</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('live/matches/today') ? 'active' : '' }}" href="{{ route('live.matches.today') }}">Dnes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('live/matches/tomorrow') ? 'active' : '' }}" href="{{ route('live.matches.tomorrow') }}">Zítra</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('live/matches/dayaftertomorrow') ? 'active' : '' }}" href="{{ route('live.matches.dayaftertomorrow') }}">Pozítří</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5 pt-5 pl-5 pr-5">
    @yield('content')
</div>

</body>
</html>
