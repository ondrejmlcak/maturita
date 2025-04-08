<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\League;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Zobrazení seznamu příspěvků.
     */
    public function index()
    {
        $posts = Post::with('league', 'author')->orderBy('created_at', 'desc')->get();

        return view('admin.posts.index', compact('posts'));
    }


    /**
     * Zobrazení formuláře pro vytvoření nového příspěvku.
     */
    public function create()
    {
        $leagues = League::all();
        $teams = Team::all();
        return view('admin.posts.create', compact('leagues', 'teams'));

    }

    /**
     * Uložení nového příspěvku.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'lead_paragraph' => 'nullable|string|max:500',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'league_id' => 'required|exists:leagues,id',
            'teams' => 'required|array',
            'teams.*' => 'exists:teams,id',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'title' => $validated['title'],
            'lead_paragraph' => $validated['lead_paragraph'],
            'description' => $validated['description'],
            'image' => $imagePath,
            'league_id' => $validated['league_id'],
            'user_id' => Auth::id(),
            'exkluzivni' => $request->has('exkluzivni') ? 'ano' : 'ne',
        ]);

        $post->teams()->sync($validated['teams']);

        return redirect()->route('admin.posts.index')->with('success', 'Příspěvek byl vytvořen.');
    }

    /**
     * Zobrazení formuláře pro úpravu příspěvku.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $leagues = League::all();
        $teams = Team::all();

        return view('admin.posts.edit', compact('post', 'leagues', 'teams'));
    }

    /**
     * Aktualizace existujícího příspěvku.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'lead_paragraph' => 'nullable|string|max:500',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'league_id' => 'required|exists:leagues,id',
            'teams' => 'nullable|array',
            'teams.*' => 'exists:teams,id',
        ]);

        $imagePath = $post->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $request->title,
            'lead_paragraph' => $request->lead_paragraph,
            'description' => $request->description,
            'image' => $imagePath,
            'league_id' => $request->league_id,
            'exkluzivni' => $request->has('exkluzivni') ? 'ano' : 'ne',
        ]);

        if ($request->has('teams')) {
            $post->teams()->sync($request->teams);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Příspěvek byl aktualizován.');
    }

    /**
     * Smazání příspěvku.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        if ($post->image) {
            \Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Příspěvek byl smazán.');
    }
}
