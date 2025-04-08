<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FootballOddsService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FootballOddsController extends Controller
{
    protected $oddsService;

    public function __construct(FootballOddsService $oddsService)
    {
        $this->oddsService = $oddsService;
    }

    public function liveMatches()
    {
        $matches = $this->oddsService->getLiveMatches();

        if (!is_array($matches)) {
            dd('Chyba: $matches není pole', $matches);
        }

        return view('livematches.live_matches', ['matches' => $matches]);
    }

    public function liveMatchesToday()
    {
        $today = Carbon::today('Europe/Prague');
        $matches = $this->oddsService->getLiveMatchesByDate($today);

        return view('livematches.live_matches', ['matches' => $matches]);
    }

    public function liveMatchesTomorrow()
    {
        $tomorrow = Carbon::tomorrow('Europe/Prague');
        $matches = $this->oddsService->getLiveMatchesByDate($tomorrow);

        return view('livematches.live_matches', ['matches' => $matches]);
    }


    public function matchOdds($id)
    {
        $matchData = $this->oddsService->getMatchOdds($id);

        if (empty($matchData)) {
            return view('livematches.match_odds', ['message' => 'Žádná data k dispozici.']);
        }

        return view('livematches.match_odds', [
            'match_info' => $matchData['match_info'] ?? [],
            'odds' => $matchData['odds'] ?? []
        ]);
    }


    public function upcomingMatches()
    {
        $matches = $this->oddsService->getUpcomingMatches();
        return view('livematches.upcoming', ['matches' => $matches]);
    }
}
