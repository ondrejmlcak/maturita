<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proč se zaregistrovat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">TipAndGo</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            @if (Route::has('login'))
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Přihlásit se</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="nav-link">Registrace</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            @endif
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Proč se zaregistrovat?</h2>
    <p class="text-center">Získáte přístup k exkluzivním funkcím:</p>

    <div class="row mt-4">
        <div class="col-md-4 text-center">
            <i class="bi bi-newspaper" style="font-size: 3rem; color: #ff6600;"></i>
            <h4 class="mt-3">Exkluzivní články</h4>
            <p>Přečtěte si analýzy, novinky a expertní komentáře.</p>
        </div>
        <div class="col-md-4 text-center">
            <i class="bi bi-tv" style="font-size: 3rem; color: #007bff;"></i>
            <h4 class="mt-3">Online zápasy</h4>
            <p>Sledujte živé výsledky a podrobné statistiky zápasů.</p>
        </div>
        <div class="col-md-4 text-center">
            <i class="bi bi-cash-stack" style="font-size: 3rem; color: #28a745;"></i>
            <h4 class="mt-3">Online vsázení</h4>
            <p>Vsaďte si na své oblíbené týmy.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
