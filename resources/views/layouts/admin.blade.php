<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet"
          href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
          crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-size: .875rem;
        }

        .feather {
            width: 16px;
            height: 16px;
            vertical-align: text-bottom;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                padding-top: 3.5rem;
            }

            .navbar-toggler {
                top: 0.5rem !important;
                right: 1rem !important;
                position: fixed !important;
                z-index: 1031;
            }
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: #333;
        }

        .sidebar .nav-link .feather {
            margin-right: 4px;
            color: #727272;
        }

        .sidebar .nav-link.active {
            color: #2470dc;
        }

        .sidebar .nav-link:hover .feather,
        .sidebar .nav-link.active .feather {
            color: inherit;
        }

        .sidebar-heading {
            font-size: .75rem;
            text-transform: uppercase;
        }

        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            font-size: 1rem;
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }

        .navbar .navbar-toggler {
            top: .25rem;
            right: 1rem;
        }

        .navbar .form-control .custom-select {
            padding: .75rem 1rem;
            border-width: 0;
            border-radius: 0;
        }

        .form-control-dark {
            color: #fff;
            background-color: rgba(255, 255, 255, .1);
            border-color: rgba(255, 255, 255, .1);
        }

        .form-control-dark:focus {
            border-color: transparent;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
        }

        #player-suggestions {
            max-height: 200px;
            overflow-y: auto;
        }

        .dashboard-card {
            transition: box-shadow 0.3s ease;
            border-radius: 1rem;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .dashboard-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        }

        .dashboard-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1F2937;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            padding-left: 10px;
            padding-top: 5px;
        }

        .dashboard-link {
            color: #2563eb;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.2s;
        }

        .dashboard-link:hover {
            text-decoration: underline;
            color: #1d4ed8;
        }

        .dashboard-date {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .dashboard-list-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .dashboard-empty {
            color: #9ca3af;
            padding: 0.75rem 0;
        }

    </style>
</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="dashboard">TipAndGo - Admin</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>
@php
    $userRole = auth()->user()->role ?? '';
@endphp

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    @if (auth()->user()->usertype === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.users.index') || Route::is('admin.users.create') || Route::is('admin.users.edit') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                Uživatelé
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.posts.index') || Route::is('admin.posts.create') || Route::is('admin.posts.edit') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">
                                Příspěvky
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.leagues.index') || Route::is('admin.leagues.create') || Route::is('admin.leagues.edit') ? 'active' : '' }}" href="{{ route('admin.leagues.index') }}">
                                Ligy
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.teams.index') || Route::is('admin.teams.create') || Route::is('admin.teams.edit') ? 'active' : '' }}" href="{{ route('admin.teams.index') }}">
                                Týmy
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.matches.index') || Route::is('admin.matches.create') || Route::is('admin.matches.available') || Route::is('admin.matches.claimed') || Route::is('admin.matches.edit') || Route::is('admin.matches.lineup') || Route::is('admin.matches.my') ? 'active' : '' }}" href="{{ route('admin.matches.index') }}">
                                Komentování zápasů
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.score.index') || Route::is('admin.score.edit') ? 'active' : '' }}" href="{{ route('admin.score.index') }}">
                                Skóre zápasů
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.tickets.index') || Route::is('admin.tickets.edit') || Route::is('admin.tickets.show') ? 'active' : '' }}" href="{{ route('admin.tickets.index') }}">
                                Tikety
                            </a>
                        </li>
                        <hr class="my-4">

                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    <i class="fa fa-tachometer me-2"></i>Uživatelský Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                    <i class="fa fa-user me-2"></i>Profil
                                </a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                                        <i class="fa fa-sign-out me-2"></i>Odhlásit se
                                    </button>
                                </form>
                            </li>
                        </ul>
                    @elseif(auth()->user()->usertype === 'editor')
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.posts.index') || Route::is('admin.posts.create') || Route::is('admin.posts.edit') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">
                                Příspěvky
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.matches.index') || Route::is('admin.matches.create') || Route::is('admin.matches.edit') || Route::is('admin.matches.lineup') ? 'active' : '' }}" href="{{ route('admin.matches.index') }}">
                                Komentování zápasů
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.score.index') || Route::is('admin.score.edit') ? 'active' : '' }}" href="{{ route('admin.score.index') }}">
                                Skóre zápasů
                            </a>
                        </li>
                                <hr class="my-4">

                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link {{ Route::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                            <i class="fa fa-tachometer me-2"></i>Uživatelský Dashboard
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ Route::is('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                            <i class="fa fa-user me-2"></i>Profil
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <form action="{{ route('logout') }}" method="POST" class="d-inline w-100">
                                            @csrf
                                            <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent">
                                                <i class="fa fa-sign-out me-2"></i>Odhlásit se
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                    @endif
                </ul>
            </div>
        </nav>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    @if(Route::is('admin.users.edit'))
                        Úprava uživatele: {{ $user->name }}
                    @elseif(Route::is('admin.dashboard'))
                        Admin Dashboard
                    @elseif(Route::is('admin.posts.index'))
                        Seznam článků
                    @elseif(Route::is('admin.posts.create'))
                        Vytvořit článek
                    @elseif(Route::is('admin.posts.create'))
                        Úprava článku
                    @elseif(Route::is('admin.users.index'))
                        Seznam uživatelů
                    @elseif(Route::is('admin.users.create'))
                        Vytvořit uživatele
                    @elseif(Route::is('admin.leagues.index'))
                        Seznam lig
                    @elseif(Route::is('admin.leagues.create'))
                        Vytvořit ligu
                    @elseif(Route::is('admin.leagues.edit'))
                        Úprava ligy: {{ $league->name }}
                    @elseif(Route::is('admin.teams.index'))
                        Seznam týmů
                    @elseif(Route::is('admin.teams.create'))
                        Vytvořit tým
                    @elseif(Route::is('admin.teams.edit'))
                        Úprava týmu: {{ $team->name }}
                    @elseif(Route::is('admin.posts.edit'))
                        Úprava článku
                    @elseif(Route::is('admin.matches.available'))
                        Dostupné zápasy k zabírání
                    @elseif(Route::is('admin.matches.claimed'))
                        Seznam všech zabraných zápasů
                    @elseif(Route::is('admin.matches.my'))
                        Moje zabrané zápasy
                    @elseif(Route::is('admin.matches.create'))
                        Vytvořit nový zápas
                    @elseif(Route::is('admin.matches.edit'))
                        Úprava zápasu
                    @elseif(Route::is('admin.matches.lineup'))
                        Úprava sestav
                    @elseif(Route::is('admin.matches.index'))
                        Správa zápasů
                    @elseif(Route::is('admin.players.index'))
                        Správa hráčů
                    @elseif(Route::is('admin.players.create'))
                        Vytvořit nového hráče
                    @elseif(Route::is('admin.players.edit'))
                        Upravit hráče
                    @elseif(Route::is('admin.tickets.index'))
                        Správa tiketů
                    @elseif(Route::is('admin.tickets.edit'))
                        Úprava tiketu
                    @elseif(Route::is('admin.score.index'))
                        Správa skóre utkání
                    @elseif(Route::is('admin.score.edit'))
                        Správa skóre utkání: {{ $match->home_team }} - {{ $match->away_team }}
                    @else
                        Dashboard
                    @endif
                </h1>
            </div>
            @include('components.flash-messages')
            @yield('content')
        </main>

    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
<script src="dashboard.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
