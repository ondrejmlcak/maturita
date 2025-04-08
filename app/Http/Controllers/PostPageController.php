<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\League;
use App\Models\Team;
use Illuminate\Http\Request;

class PostPageController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        $leagues = League::all();

        return view('posts.index', compact('posts', 'leagues'));
    }

    public function showByLeague($slug)
    {
        $league = League::where('slug', $slug)->first();

        if (!$league) {
            return redirect()->to(route('posts.index') . '/');
        }

        $posts = Post::where('league_id', $league->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $leagues = League::all();

        return view('posts.index', compact('posts', 'league', 'leagues'));
    }


    public function showByTeam($leagueSlug, $teamSlug)
    {
        $league = League::where('slug', $leagueSlug)->first();

        if (!$league) {
            return redirect()->to(route('posts.index') . '/');
        }

        $team = Team::where('slug', $teamSlug)
            ->where('league_id', $league->id)
            ->first();

        if (!$team) {
            return redirect()->to(route('posts.index') . '/');
        }

        $posts = Post::where('league_id', $league->id)
            ->whereHas('teams', function ($query) use ($team) {
                $query->where('teams.id', $team->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $leagues = League::all();

        return view('posts.index', compact('posts', 'league', 'team', 'leagues'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return redirect()->route('posts.index');
        }

        $posts = Post::where('title', 'like', '%' . $query . '%')
            ->orderBy('created_at', 'desc')
            ->get();

        $leagues = League::all();

        return view('posts.index', compact('posts', 'leagues'));
    }


    public function show($slug)
    {
        $post = Post::where('slug', $slug)->first();

        if (!$post) {
            return redirect()->route('posts.index' . '/');
        }

        $post->description = preg_replace_callback(
            '/https:\/\/www\.youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',
            function ($matches) {
                return '<div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/' . $matches[1] . '" allowfullscreen></iframe>
                    </div>';
            },
            $post->description
        );

        $leagues = League::all();

        return view('posts.show', compact('post', 'leagues'));
    }

    public function create()
    {
        $leagues = League::all();
        return view('posts.create', compact('leagues'));
    }
}
