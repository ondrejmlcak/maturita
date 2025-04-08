<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Models\Zapas;
use App\Models\Team;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MatchTimeline;
use Illuminate\Validation\Rule;


class ZapasController extends Controller
{
    public function create()
    {
        $teams = Team::all();
        $leagues = League::all();
        return view('admin.matches.create', compact('teams', 'leagues'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id',
            'league_id' => 'nullable|exists:leagues,id',
            'match_date' => 'required|date',
            'stadium_name' => 'nullable|string|max:255',
            'fan_count' => 'nullable|integer|min:0',
            'referee' => 'nullable|string|max:255',
            'home_team_lineup' => 'nullable|array',
            'away_team_lineup' => 'nullable|array',
            'home_team_substitutes' => 'nullable|array',
            'away_team_substitutes' => 'nullable|array',
            'round_number' => 'required|integer',
        ]);

        $matchDate = Carbon::parse($validated['match_date']);

        Zapas::create([
            'home_team_id' => $validated['home_team_id'],
            'away_team_id' => $validated['away_team_id'],
            'referee' => $validated['referee'] ?? null,
            'match_date' => $matchDate,
            'stadium' => $validated['stadium_name'] ?? null,
            'fans_count' => $validated['fan_count'] ?? 0,
            'home_lineup' => implode(',', $validated['home_team_lineup'] ?? []),
            'away_lineup' => implode(',', $validated['away_team_lineup'] ?? []),
            'home_substitutes' => implode(',', $validated['home_team_substitutes'] ?? []),
            'away_substitutes' => implode(',', $validated['away_team_substitutes'] ?? []),
            'league_id' => $validated['league_id'] ?? null,
            'round_number' => $validated['round_number'],
        ]);

        return redirect()->route('admin.matches.index')->with('success', 'Zápas byl vytvořen.');
    }

    public function edit(Zapas $match)
    {
        $teams = Team::all();
        $comments = $match->comments()->with('user')->orderBy('created_at', 'desc')->get();
        $events = $match->timeline()->get();
        $homeLineup = explode(',', $match->home_lineup);
        $awayLineup = explode(',', $match->away_lineup);
        $homeSubstitutes = explode(',', $match->home_substitutes);
        $awaySubstitutes = explode(',', $match->away_substitutes);

        $statusOptions = ['before' => 'Před zápasem', '1st' => 'První poločas', 'half_time' => 'Poločas', '2nd' => 'Druhý poločas', 'full_time' => 'Konec', 'after_90' => 'Po 90 minutách', '1st_extra' => 'První prodloužení', 'after_105' => 'Pauza po prodloužení', '2nd_extra' => 'Druhé prodloužení', 'penalty' => 'Penaltový rozstřel', 'suspended' => 'Nedohráno'];
        $status = $match->status ?? 'before';

        return view('admin.matches.edit', compact(
            'match', 'teams', 'comments', 'events',
            'homeLineup', 'awayLineup', 'homeSubstitutes', 'awaySubstitutes',
            'statusOptions', 'status'
        ));
    }

    public function update(Request $request, Zapas $match)
    {
        $validated = $request->validate([
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'home_lineup' => 'nullable|string',
            'away_lineup' => 'nullable|string',
            'home_substitutes' => 'nullable|string',
            'away_substitutes' => 'nullable|string',
            'status' => ['nullable', Rule::in(['before', '1st', 'half_time', '2nd', 'full_time', 'after_90', '1st_extra', 'after_105', '2nd_extra', 'penalty', 'suspended'])],
            'round_number' => 'nullable|integer|min:1',
            'fan_count' => 'nullable|integer|min:0',
            'referee' => 'nullable|string|max:255',
            'stadium_name' => 'nullable|string|max:255',
        ]);

        $match->update([
            'home_score' => $validated['home_score'] ?? 0,
            'away_score' => $validated['away_score'] ?? 0,
            'home_lineup' => $validated['home_lineup'] ?? '',
            'away_lineup' => $validated['away_lineup'] ?? '',
            'home_substitutes' => $validated['home_substitutes'] ?? '',
            'away_substitutes' => $validated['away_substitutes'] ?? '',
            'round_number' => $validated['round_number'] ?? null,
            'fans_count' => $validated['fan_count'] ?? 0,
            'referee' => $validated['referee'] ?? '',
            'stadium' => $validated['stadium_name'] ?? '',
            'status' => $validated['status'] ?? $match->status,
        ]);


        return back()->with('success', 'Zápas byl aktualizován.');
    }

    public function deleteEvent($eventId)
    {
        $event = MatchTimeline::findOrFail($eventId);
        $event->delete();

        return back()->with('success', 'Událost byla smazána.');
    }


    public function updateLineup(Request $request, Zapas $match)
    {
        $validated = $request->validate([
            'home_lineup' => 'nullable|array|max:11',
            'away_lineup' => 'nullable|array|max:11',
            'home_substitutes' => 'nullable|array',
            'away_substitutes' => 'nullable|array',
        ]);

        $match->home_lineup = implode(',', $validated['home_lineup'] ?? []);
        $match->away_lineup = implode(',', $validated['away_lineup'] ?? []);
        $match->home_substitutes = implode(',', $validated['home_substitutes'] ?? []);
        $match->away_substitutes = implode(',', $validated['away_substitutes'] ?? []);

        $match->save();

        return redirect()->back()->with('success', 'Sestava byla uložena.');
    }


    public function addComment(Request $request, Zapas $match)
    {
        $validated = $request->validate([
            'event_type' => 'required|in:goal,yellow_card,red_card,substitution,normal,important',
            'minute' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $comment = new Comment();
        $comment->zapas_id = $match->id;
        $comment->event_type = $validated['event_type'];
        $comment->minute = $validated['minute'] ?? 0;
        $comment->description = $validated['description'];
        $comment->save();

        return back()->with('success', 'Komentář byl přidán.');
    }

    public function addEvent(Request $request, Zapas $match)
    {
        $validated = $request->validate([
            'minute' => 'required|integer|min:1',
            'team_id' => 'required|exists:teams,id',
            'event_type' => 'required|string',
            'player_name' => 'required|string',
        ]);
        $event = new MatchTimeline();
        $event->match_id = $match->id;
        $event->team_id = $validated['team_id'];
        $event->event_type = $validated['event_type'];
        $event->minute = $validated['minute'];
        $event->player_name = $validated['player_name'];
        $event->save();

        return back()->with('success', 'Událost byla přidána.');
    }

    public function showTimeline($matchId)
{
    $match = Zapas::findOrFail($matchId);

    $events = MatchTimeline::where('match_id', $match->id)->get();

    $teams = Team::all();

    return view('admin.matches.timeline', compact('match', 'events', 'teams'));
}

    public function updateComment(Request $request, Zapas $match, Comment $comment)
    {
        $validated = $request->validate([
            'minute' => 'nullable|integer|min:0',
            'event_type' => 'required|in:goal,yellow_card,red_card,substitution,normal,important',
            'description' => 'nullable|string|max:255',
        ]);

        $comment->minute = $validated['minute'] ?? $comment->minute;
        $comment->event_type = $validated['event_type'];
        $comment->description = $validated['description'] ?? $comment->description;
        $comment->save();

        return back()->with('success', 'Komentář byl úspěšně aktualizován.');
    }


    public function deleteComment($matchId, $commentId)
    {
        $comment = Comment::where('zapas_id', $matchId)->findOrFail($commentId);
        $comment->delete();

        return redirect()->route('admin.matches.edit', $matchId)->with('success', 'Komentář byl úspěšně smazán.');
    }




    public function index()
    {
        $matches = Zapas::whereNull('commentator_id')->get();
        $noMatchesAvailable = $matches->isEmpty();
        return view('admin.matches.index', compact('matches', 'noMatchesAvailable'));
    }

    public function available()
    {
        $matches = Zapas::whereNull('commentator_id')->get();
        $noMatchesAvailable = $matches->isEmpty();
        return view('admin.matches.available', compact('matches', 'noMatchesAvailable'));
    }

    public function my()
    {
        $claimedMatches = Zapas::where('commentator_id', auth()->id())->get();
        return view('admin.matches.my', compact('claimedMatches'));
    }

    public function claimed()
    {
        $allClaimedMatches = Zapas::whereNotNull('commentator_id')
            ->with('commentator')
            ->get();
        return view('admin.matches.claimed', compact('allClaimedMatches'));
    }

    public function claimMatch($id)
    {
        $match = Zapas::findOrFail($id);
        $match->commentator_id = auth()->user()->id;
        $match->save();

        return redirect()->route('admin.matches.index')->with('success', 'Zápas byl úspěšně zabrán.');
    }
}
