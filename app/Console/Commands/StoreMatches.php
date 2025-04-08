<?php

namespace App\Console\Commands;

use App\Services\FootballOddsService;
use Illuminate\Console\Command;
use App\Models\Utkani;

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
            $existingMatch = Utkani::where('match_id', $match['id'])->first();

            if (!$existingMatch || $existingMatch->status !== 'Ended') {
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
        }

        $this->info('Zápasy byly uloženy nebo aktualizovány!');
    }
}
