<?php
use App\Http\Controllers\BetController;
use App\Http\Controllers\MatchPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckUserRole;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\LeagueController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\ZapasController;
use App\Http\Controllers\Api\FootballOddsController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\UtkaniController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'userDashboard'])->name('dashboard');

    Route::middleware([CheckUserRole::class . ':admin'])->group(function () {
        Route::get('admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

        Route::get('admin/tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
        Route::get('admin/tickets/{id}', [TicketController::class, 'show'])->name('admin.tickets.show');
        Route::get('admin/tickets/{id}/edit', [TicketController::class, 'edit'])->name('admin.tickets.edit');
        Route::post('admin/tickets', [TicketController::class, 'store'])->name('admin.tickets.store');
        Route::patch('admin/tickets/{id}', [TicketController::class, 'update'])->name('admin.tickets.update');
        Route::delete('admin/tickets/{id}', [TicketController::class, 'destroy'])->name('admin.tickets.destroy');

        Route::get('admin/matches/create', [ZapasController::class, 'create'])->name('admin.matches.create');

        Route::get('admin/leagues', [LeagueController::class, 'index'])->name('admin.leagues.index');
        Route::get('admin/teams', [TeamController::class, 'index'])->name('admin.teams.index');
        Route::get('admin/leagues/create', [LeagueController::class, 'create'])->name('admin.leagues.create');
        Route::get('admin/teams/create', [TeamController::class, 'create'])->name('admin.teams.create');
        Route::post('admin/leagues', [LeagueController::class, 'store'])->name('admin.leagues.store');
        Route::post('admin/teams', [TeamController::class, 'store'])->name('admin.teams.store');
        Route::get('admin/leagues/{league}/edit', [LeagueController::class, 'edit'])->name('admin.leagues.edit');
        Route::get('admin/teams/{team}/edit', [TeamController::class, 'edit'])->name('admin.teams.edit');
        Route::put('admin/leagues/{league}', [LeagueController::class, 'update'])->name('admin.leagues.update');
        Route::put('admin/teams/{team}', [TeamController::class, 'update'])->name('admin.teams.update');
        Route::delete('admin/leagues/{league}', [LeagueController::class, 'destroy'])->name('admin.leagues.destroy');
        Route::delete('admin/teams/{team}', [TeamController::class, 'destroy'])->name('admin.teams.destroy');

        Route::fallback(function () {
            return redirect()->route('admin.dashboard');
        });
    });
    
    Route::middleware([CheckUserRole::class . ':editor,admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');

        Route::get('admin/posts', [PostController::class, 'index'])->name('admin.posts.index');
        Route::get('admin/posts/create', [PostController::class, 'create'])->name('admin.posts.create');
        Route::post('admin/posts', [PostController::class, 'store'])->name('admin.posts.store');
        Route::get('admin/posts/{post}/edit', [PostController::class, 'edit'])->name('admin.posts.edit');
        Route::put('admin/posts/{post}', [PostController::class, 'update'])->name('admin.posts.update');
        Route::delete('admin/posts/{post}', [PostController::class, 'destroy'])->name('admin.posts.destroy');

        Route::get('admin/score', [UtkaniController::class, 'index'])->name('admin.score.index');
        Route::get('admin/score/edit/{id}', [UtkaniController::class, 'edit'])->name('admin.score.edit');
        Route::put('admin/score/update/{id}', [UtkaniController::class, 'update'])->name('admin.score.update');
        Route::post('admin/score/delete/{id}', [UtkaniController::class, 'delete'])->name('admin.score.delete');

        Route::delete('admin/matches/{match}/comments/{comment}', [ZapasController::class, 'deleteComment'])->name('admin.matches.deleteComment');
        Route::post('/admin/matches/{match}/timeline', [ZapasController::class, 'addEvent'])->name('admin.matches.addEvent');
        Route::delete('admin/matches/{event}/remove-timeline-event', [ZapasController::class, 'removeTimelineEvent'])->name('admin.matches.removeTimelineEvent');

        Route::put('admin/matches/{match}/comments/{comment}', [ZapasController::class, 'updateComment'])->name('admin.matches.updateComment');
        Route::delete('admin/matches/{match}/events/{event}', [ZapasController::class, 'deleteEvent'])->name('admin.matches.deleteEvent');

        Route::post('admin/matches', [ZapasController::class, 'store'])->name('admin.matches.store');
        Route::post('admin/matches/{match}/claim', [ZapasController::class, 'claimMatch'])->name('admin.matches.claim');
        Route::get('admin/matches/{match}/edit', [ZapasController::class, 'edit'])->name('admin.matches.edit');
        Route::put('admin/matches/{match}', [ZapasController::class, 'update'])->name('admin.matches.update');
        Route::post('/admin/matches/{match}/comment', [ZapasController::class, 'addComment'])->name('admin.matches.addComment');
        Route::patch('/admin/matches/comment/{comment}', [ZapasController::class, 'updateComment'])->name('admin.matches.updateComment');
        Route::patch('admin/matches/{match}/comments/{comment}', [ZapasController::class, 'updateComment'])->name('admin.matches.updateComment');

        Route::get('admin/matches', [ZapasController::class, 'index'])->name('admin.matches.index');
        Route::get('admin/matches/available', [ZapasController::class, 'available'])->name('admin.matches.available');
        Route::get('admin/matches/my', [ZapasController::class, 'my'])->name('admin.matches.my');
        Route::get('admin/matches/claimed', [ZapasController::class, 'claimed'])->name('admin.matches.claimed');
        Route::fallback(function () {
            return redirect()->route('admin.dashboard');
        });
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});

use App\Http\Controllers\PostPageController;

Route::middleware(['auth'])->group(function () {
    Route::get('/posts', [PostPageController::class, 'index'])->name('posts.index');
    Route::get('/posts/author/{id}', [PostPageController::class, 'showByAuthor'])->name('posts.byAuthor');
    Route::get('/posts/{slug}', [PostPageController::class, 'showByLeague'])->name('posts.showByLeague');
    Route::get('/post/{slug}', [PostPageController::class, 'show'])->name('posts.show');
    Route::get('/search', [PostPageController::class, 'search'])->name('posts.search');
    Route::get('/posts/{leagueSlug}/{teamSlug}', [PostPageController::class, 'showByTeam'])->name('posts.showByTeam');

    Route::get('/matches', [MatchPageController::class, 'index'])->name('matches.index');
    Route::get('/matches/{id}', [MatchPageController::class, 'show'])->name('matches.show');
    Route::get('/matches/date/{date}', [MatchPageController::class, 'showByDate'])->name('matches.showByDate');

    Route::get('/live/matches/today', [FootballOddsController::class, 'liveMatchesToday'])->name('live.matches.today');
    Route::get('/live/matches/tomorrow', [FootballOddsController::class, 'liveMatchesTomorrow'])->name('live.matches.tomorrow');
    Route::get('/live/matches/day-after-tomorrow', [FootballOddsController::class, 'liveMatchesDayAfterTomorrow'])->name('live.matches.dayaftertomorrow');

    Route::get('/live/matches', [FootballOddsController::class, 'liveMatches'])->name('live.matches');
    Route::get('/live/matches/{id}/odds', [FootballOddsController::class, 'matchOdds'])->name('match.odds');

    Route::post('/ticket/add', [BetController::class, 'addToTicket'])->name('ticket.add');
    Route::get('/ticket', [BetController::class, 'viewTicket'])->name('ticket.view');
    Route::post('/ticket/place', [BetController::class, 'placeTicket'])->name('ticket.place');
    Route::get('/tickets', [BetController::class, 'allTickets'])->name('ticket.all');
    Route::delete('/ticket/remove/{index}', [BetController::class, 'removeFromTicket'])->name('ticket.remove');

    Route::get('/live/matches/{any}', function() {
        return redirect()->route('live.matches');
    })->where('any', '.*');

});

require __DIR__.'/auth.php';
