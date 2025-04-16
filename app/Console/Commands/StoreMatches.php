<?php

namespace App\Console\Commands;

use App\Services\FootballOddsService;
use Illuminate\Console\Command;
use App\Models\Utkani;

//uklada zapasy do db za pomoci prikazu v artisanu, kdyz je zapas se stejnym jmenem a datem, jeden zapas se neposle
// Kdyz je status zapasu ended, neposle se znovu do db.
class StoreMatches extends Command
{
    protected $signature = 'matches:store';
    protected $description = 'Uloží všechny zápasy do databáze';
    protected FootballOddsService $oddsService;

    public function __construct(FootballOddsService $oddsService)
    {
        parent::__construct();
        $this->oddsService = $oddsService;
    }

    public function handle()
    {
        $matches = $this->oddsService->getAllMatches();

        foreach ($matches as $match) {
            $duplicate = Utkani::where('home_team', $match['home_team'])
                ->where('away_team', $match['away_team'])
                ->where('start_time', $match['start_time'])
                ->first();

            if ($duplicate) {
                $this->line("Zápas {$match['home_team']} vs {$match['away_team']} již existuje ve stejný čas.");
                continue;
            }

            Utkani::updateOrCreate(
                ['match_id' => $match['id']],
                [
                    'home_team' => $match['home_team'],
                    'away_team' => $match['away_team'],
                    'score' => $match['score'],
                    'status' => $match['status'],
                    'league' => $match['league'],
                    'start_time' => $match['start_time'],
                    'minutes' => $match['minutes'],
                ]
            );
        }

        $this->info('Zápasy byly uloženy nebo aktualizovány!');
    }
}
