<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\FootballOddsService;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;

class TicketController extends Controller
{
    /**
     * Zobrazení seznamu tiketů.
     */
    public function index()
    {
        $tickets = Ticket::with('user')->orderByDesc('created_at')->get();
        return view('admin.tickets.index', compact('tickets'));
    }


    /**
     * Zobrazení detailu konkrétního tiketu.
     */
    public function show($id)
    {
        $ticket = Ticket::with('bets.match', 'user')->findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Zobrazení formuláře pro úpravu tiketu.
     */
    public function edit($id)
    {
        $ticket = Ticket::with('bets.match')->find($id);

        if (!$ticket) {
            return redirect()->route('admin.tickets.index')->with('error', 'Tiket nebyl nalezen.');
        }

        $match = $ticket->bets->first()->match ?? null;

        $matchInfo = $match ? [
            'league' => $match->league,
            'home_team' => $match->home_team,
            'away_team' => $match->away_team,
            'score' => $match->score ?? 'N/A',
            'status' => $match->status ?? 'N/A',
            'start_time' => $match->start_time ?? 'N/A',
            'minutes' => $match->minutes ?? 'N/A',
        ] : [
            'league' => 'Neznámá liga',
            'home_team' => 'Neznámý tým',
            'away_team' => 'Neznámý tým',
            'score' => '0-0',
            'status' => 'Neznámý stav',
            'start_time' => 'Neznámý čas',
            'minutes' => 0,
        ];

        return view('admin.tickets.edit', compact('ticket', 'matchInfo'));
    }

    /**
     * Uložení nového tiketu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'stake' => 'required|numeric|min:1',
            'final_win' => 'nullable|numeric',
        ], [
            'stake.required' => 'Sázka je povinná',
            'stake.numeric' => 'Sázka musí být číslo',
            'stake.min' => 'Sázka musí být alespoň 1',
            'final_win.numeric' => 'Výhra musí být číslo'
        ]);

        $ticket = Ticket::create([
            'user_id' => auth()->id(),
            'stake' => $validated['stake'],
            'final_win' => $validated['final_win'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Tiket byl úspěšně vytvořen.');
    }

    /**
     * Aktualizace tiketu (změna statusu, vyplacení výhry).
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,won,lost',
            'final_win' => 'nullable|numeric|min:0',
        ], [
            'status.required' => 'Status je povinný',
            'status.in' => 'Neplatný status tiketu',
            'final_win.numeric' => 'Výhra musí být číslo',
            'final_win.min' => 'Výhra nemůže být záporná'
        ]);

        if ($ticket->user) {
            $user = $ticket->user;

            if ($validated['status'] === 'won' && $ticket->status !== 'won') {
                $user->money += $ticket->final_win;
            }
            elseif ($validated['status'] === 'lost' && $ticket->status === 'won') {
                $user->money -= $ticket->final_win;
            }

            $user->save();
        }

        $ticket->status = $validated['status'];
        $ticket->save();

        return redirect()->route('admin.tickets.index')
            ->with('success', 'Tiket byl úspěšně aktualizován.');
    }

    /**
     * Odstranění tiketu.
     */
    public function destroy($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            $ticket->delete();
            return redirect()->route('admin.tickets.index')
                ->with('success', 'Tiket byl úspěšně smazán.');
        } catch (\Exception $e) {
            return redirect()->route('admin.tickets.index')
                ->with('error', 'Tiket se nepodařilo smazat.');
        }
    }
}
