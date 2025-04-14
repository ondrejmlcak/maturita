<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\League;
use Illuminate\Http\Request;

class LeagueController extends Controller
{
    public function index()
    {
        $leagues = League::all();
        return view('admin.leagues.index', compact('leagues'));
    }

    public function create()
    {
        return view('admin.leagues.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        League::create($request->all());
        return redirect()->route('admin.leagues.index')->with('success', 'Liga byla úspěšně vytvořena.');
    }

    public function show(League $league)
    {
        return view('admin.leagues.show', compact('league'));
    }

    public function edit($id)
    {
        $league = League::find($id);

        if (!$league) {
            return redirect()->route('admin.leagues.index')->with('error', 'Liga nebyla nalezena.');
        }

        return view('admin.leagues.edit', compact('league'));
    }


    public function update(Request $request, League $league)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $league->update($request->all());
        return redirect()->route('admin.leagues.index')->with('success', 'Liga byla úspěšně aktualizována.');
    }

    public function destroy(League $league)
    {
        try {
            $league->delete();
            return redirect()->route('admin.leagues.index')->with('success', 'Liga byla úspěšně smazána.');
        } catch (\Exception $e) {
            return redirect()->route('admin.leagues.index')->with('error', 'Ligu nelze smazat, protože obsahuje závislé záznamy.');
        }
    }
}
