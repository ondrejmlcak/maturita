<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Ticket;
use App\Models\Zapas;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    //User uvidi sve 3 tikety
    public function userDashboard()
    {
        $latestTickets = Ticket::with('bets.match')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('dashboard.user', compact('latestTickets'));
    }



    //Do adminu da 5 posledni postu a 4 posledni zapasy
    public function adminDashboard()
    {
        $latestPosts = Post::latest()->take(5)->get();
        $latestMatches = Zapas::latest()->take(4)->get();
        return view('dashboard.admin', compact('latestPosts', 'latestMatches'));
    }
}
