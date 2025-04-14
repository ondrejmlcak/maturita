<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    /**
     * Zobrazení seznamu týmů.
     */
    public function index()
    {
        $teams = Team::with('league')->get();

        return view('admin.teams.index', compact('teams'));
    }

    /**
     * Zobrazení formuláře pro vytvoření nového týmu.
     */
    public function create()
    {
        $leagues = League::all();

        return view('admin.teams.create', compact('leagues'));
    }

    /**
     * Uložení nového týmu.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'league_id' => 'required|exists:leagues,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teams', 'public');
        }

        Team::create([
            'name' => $request->name,
            'league_id' => $request->league_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.teams.index')->with('success', 'Tým byl vytvořen.');
    }

    /**
     * Zobrazení formuláře pro úpravu týmu.
     */
    public function edit(string $id)
    {
        $team = Team::find($id);

        if (!$team) {
            return redirect()->route('admin.teams.index')->with('error', 'Tým nebyl nalezen.');
        }

        $leagues = League::all();

        return view('admin.teams.edit', compact('team', 'leagues'));
    }


    /**
     * Aktualizace existujícího týmu.
     */
    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'league_id' => 'required|exists:leagues,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $team->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teams', 'public');
        }

        $team->update([
            'name' => $request->name,
            'league_id' => $request->league_id,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.teams.index')->with('success', 'Tým byl aktualizován.');
    }

    /**
     * Smazání týmu.
     */
    public function destroy(Team $team)
    {
        if ($team->image) {
            Storage::disk('public')->delete($team->image);
        }

        $team->delete();

        return redirect()->route('admin.teams.index')->with('success', 'Tým byl smazán.');
    }
}
