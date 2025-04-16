<?php

namespace App\Http\Controllers;

use App\Models\League;
use Illuminate\Http\Request;
use App\Models\Zapas;
use Carbon\Carbon;

class MatchPageController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = $request->query('date', Carbon::now()->toDateString());
        $leagueId = $request->query('league');

        $prevDate = Carbon::parse($currentDate)->subDay()->toDateString();
        $nextDate = Carbon::parse($currentDate)->addDay()->toDateString();

        $query = Zapas::whereDate('match_date', $currentDate);
        if ($leagueId) {
            $query->where('league_id', $leagueId);
        }
        $matches = $query->orderBy('match_date', 'asc')->get();

        $leagues = League::all();

        return view('matches.index', compact('matches', 'currentDate', 'prevDate', 'nextDate', 'leagues', 'leagueId'));
    }

    public function show($id)
    {
        $match = Zapas::with('homeTeam', 'awayTeam', 'comments')->findOrFail($id);

        $comments = $match->comments()->orderByDesc('minute')->get();
        $events = $match->timeline()->get();

        $homeLineup = explode(',', $match->home_lineup);
        $awayLineup = explode(',', $match->away_lineup);
        $homeSubstitutes = explode(',', $match->home_substitutes);
        $awaySubstitutes = explode(',', $match->away_substitutes);

        return view('matches.show', compact(
            'match',
            'comments', 'events',
            'homeLineup',
            'awayLineup',
            'homeSubstitutes',
            'awaySubstitutes'
        ));
    }


    //ukaze zapasy podle data
    public function showByDate($date)
    {
        $currentDate = Carbon::parse($date)->toDateString();

        $prevDate = Carbon::parse($currentDate)->subDay()->toDateString();
        $nextDate = Carbon::parse($currentDate)->addDay()->toDateString();

        $matches = Zapas::whereDate('match_date', $currentDate)
            ->orderBy('match_date', 'asc')
            ->get();

        return view('matches.index', compact('matches', 'currentDate', 'prevDate', 'nextDate'));
    }
}
