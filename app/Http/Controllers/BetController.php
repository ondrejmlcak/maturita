<?php

namespace App\Http\Controllers;

use App\Models\Bet;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Utkani;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BetController extends Controller
{
    // pridame do tiketu
    public function addToTicket(Request $request)
    {
        $match = Utkani::where('match_id', $request->match_id)->first();
        $ticket = session()->get('ticket', []);

        foreach ($ticket as $bet) {
            if ($bet['match_id'] == $request->match_id) {
                return redirect()->route('match.odds', ['id' => $request->match_id])
                    ->with('error', 'Tento zápas už je v tiketu. Na jeden zápas můžete vsadit pouze jednou.');
            }
        }

        $ticket[] = [
            'match_id' => $request->match_id,
            'leagues' => $request->input('leagues', 'Neznámá liga'),
            'home_team' => $match->home_team ?? 'Neznámý tým',
            'away_team' => $match->away_team ?? 'Neznámý tým',
            'bet_type' => $request->input('bet_type'),
            'odd' => $request->input('odd'),
            'amount' => $request->input('amount', 0)
        ];

        session(['ticket' => $ticket]);

        return redirect()->route('match.odds', ['id' => $request->match_id])->with('success', 'Příležitost byla přidána na tiket!');
    }


    public function viewTicket()
    {
        $ticket = session()->get('ticket', []);

        return view('livematches.ticket', compact('ticket'));
    }

    // ukaze vsechny uzivatelovy tikety
    public function allTickets()
    {
        $user = Auth::user();

        $tickets = Ticket::with('bets.match')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livematches.all_tickets', compact('tickets'));
    }

    // ulozime tiket do db
    public function placeTicket(Request $request)
    {
        $user = Auth::user();
        $stake = $request->amount;

        if ($user->money < $stake) {
            return redirect()->back()->with('error', 'Nemáte dostatek peněz na sázku.');
        }
        $user->money -= $stake;
        $user->save();
        $ticket = new Ticket([
            'user_id' => $user->id,
            'stake' => $stake,
        ]);

        $totalOdds = 1;
        foreach (session()->get('ticket', []) as $bet) {
            $totalOdds *= $bet['odd'];
        }
        $finalWin = round($stake * $totalOdds, 2);
        $ticket->final_win = $finalWin;

        $ticket->save();

        foreach (session()->get('ticket', []) as $bet) {
            Bet::create([
                'ticket_id' => $ticket->id,
                'match_id' => $bet['match_id'],
                'bet_type' => $bet['bet_type'],
                'odd' => $bet['odd']
            ]);
        }

        session()->forget('ticket');
        session()->put('potential_win', $finalWin);

        return redirect()->back()->with('success', 'Tiket byl úspěšně podán.');
    }

    // odebere prilezitost z tiketu
    public function removeFromTicket($index)
    {
        $ticket = session()->get('ticket', []);

        if (isset($ticket[$index])) {
            unset($ticket[$index]);
            $ticket = array_values($ticket);
            session(['ticket' => $ticket]);
            return redirect()->back()->with('success', 'Zápas byl odebrán z tiketu.');
        }

        return redirect()->back()->with('error', 'Zápas nebyl nalezen v tiketu.');
    }
}
