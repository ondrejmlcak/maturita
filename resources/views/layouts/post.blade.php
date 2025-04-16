<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(Route::currentRouteName() == 'posts.index')
            Články - TipAndGo
        @elseif(Route::currentRouteName() == 'posts.showByLeague' && isset($league) && !empty($league->name))
            {{ $league->name }} - TipAndGo
        @elseif(Route::currentRouteName() == 'posts.showByTeam' && isset($team) && !empty($team->name))
            {{ $team->name }} - {{ $league->name }} - TipAndGo
        @elseif(Route::currentRouteName() == 'posts.byAuthor' && isset($author) && !empty($author->name))
            {{ $author->name }} - TipAndGo
        @elseif(isset($post) && !empty($post->title))
            {{ $post->title }} - TipAndGo
        @elseif(request('query'))
            Výsledky vyhledávání pro: "{{ request('query') }}" - TipAndGo
        @else
            Články - TipAndGo
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
                padding: 5px;
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
            .post-card h2 a {
                font-size: 23px;
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
        .post-content p {
            font-size: 20px;
            line-height: 1.6;
        }

         .top-header {
             background-color: white;
             border-bottom: 1px solid #ddd;
             position: fixed;
             top: 0;
             width: 100%;
             z-index: 1030;
         }

        .top-header h1 {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
        }

        .navbar-custom {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            position: fixed;
            top: 50px;
            width: 100%;
            z-index: 1020;
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

        .container-main {
            padding-top: 140px;
        }
        #scrollToTopBtn {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1040;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            padding: 12px 16px;
            border-radius: 50%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: opacity 0.3s ease-in-out;
        }

        #scrollToTopBtn:hover {
            background-color: #0056b3;
        }

        .post-image {
            width: 100%;
            height: auto;
            max-width: 100%;
            display: block;
            margin: 0 auto;
        }


    </style>
</head>
<body>

<header class="top-header py-2 shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') . '/' }}" class="text-dark text-decoration-none">
            Dashboard
        </a>
        <a href="{{ route('posts.index') . '/' }}" class="text-dark text-decoration-none">
            <h1 class="mb-0">TipAndGo</h1>
        </a>
        <div style="width: 80px;"></div>
    </div>
</header>



<nav class="navbar navbar-expand-lg navbar-light navbar-custom">
    <div class="container d-flex justify-content-between">
        <form class="form-inline my-2 my-lg-0" method="GET" action="{{ route('posts.search') . '/' }}">
            <input class="form-control search-bar mr-3" type="search" minlength="2" maxlength="20" placeholder="Hledat články..." aria-label="Search" name="query" value="{{ request('query') }}" required>
        </form>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto d-flex align-items-center">
                @foreach($leagues as $league)
                    <li class="nav-item mr-1">
                        <a class="nav-link" href="{{ route('posts.showByLeague', $league->slug) . '/' }}">{{ $league->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>


<div class="container container-main pl-5 pr-5">
    <div class="content-area pl-5 pr-5">
        @yield('content')
    </div>
</div>

<footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bg-dark py-3">
                    <p class="mb-0">© 2025 TipAndGo - Všechna práva vyhrazena</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<button id="scrollToTopBtn" class="btn btn-primary" title="Zpět nahoru">
    <i class="fas fa-arrow-up"></i>
</button>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    const scrollToTopBtn = document.getElementById("scrollToTopBtn");

    window.onscroll = function () {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    };

    scrollToTopBtn.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>

</body>
</html>
