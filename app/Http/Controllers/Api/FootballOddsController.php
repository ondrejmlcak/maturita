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
        $sortedMatches = collect($matches)->sortBy('start_time')->values()->all();

        return view('livematches.live_matches', ['matches' => $sortedMatches]);
    }

    public function liveMatchesToday()
    {
        $today = Carbon::today('Europe/Prague');
        $matches = $this->oddsService->getLiveMatchesByDate($today);
        $sortedMatches = collect($matches)->sortBy('start_time')->values()->all();

        return view('livematches.live_matches', ['matches' => $sortedMatches]);
    }

    public function liveMatchesTomorrow()
    {
        $tomorrow = Carbon::tomorrow('Europe/Prague');
        $matches = $this->oddsService->getLiveMatchesByDate($tomorrow);
        $sortedMatches = collect($matches)->sortBy('start_time')->values()->all();

        return view('livematches.live_matches', ['matches' => $sortedMatches]);
    }

    public function liveMatchesDayAfterTomorrow()
    {
        $dayAfterTomorrow = Carbon::today('Europe/Prague')->addDays(2);
        $matches = $this->oddsService->getLiveMatchesByDate($dayAfterTomorrow);
        $sortedMatches = collect($matches)->sortBy('start_time')->values()->all();

        return view('livematches.live_matches', ['matches' => $sortedMatches]);
    }

    public function matchOdds($id)
    {
        $matchData = $this->oddsService->getMatchOdds($id);

        if (empty($matchData)) {
            return redirect()->action([self::class, 'liveMatches'])
                ->with('error', 'Zápas nebyl nalezen nebo neexistují dostupná data.');
        }

        return view('livematches.match_odds', [
            'match_info' => $matchData['match_info'] ?? [],
            'odds' => $matchData['odds'] ?? []
        ]);
    }
}
