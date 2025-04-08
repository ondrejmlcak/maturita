<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\Utkani;
use Carbon\Carbon;

class FootballOddsService
{
    protected $client;
    protected $apiUrl = 'https://football-betting-odds1.p.rapidapi.com/provider1/live/list';
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('RAPIDAPI_KEY');
    }


    public function getLiveMatches()
    {
        try {
            $response = $this->client->request('GET', $this->apiUrl, [
                'headers' => [
                    'x-rapidapi-host' => 'football-betting-odds1.p.rapidapi.com',
                    'x-rapidapi-key' => $this->apiKey,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (!isset($data) || empty($data)) {
                return [];
            }

            $now = Carbon::now('UTC')->timestamp;

            return array_filter(array_map(function ($match, $id) use ($now) {
                $matchStart = $match['startTime'] ?? null;

                if (!$matchStart || $matchStart < $now) {
                    return null;
                }

                $startTime = Carbon::createFromTimestampUTC($matchStart)->setTimezone('Europe/Prague');

                return [
                    'id' => $id,
                    'home_team' => $match['home'] ?? 'Neznámý tým',
                    'away_team' => $match['away'] ?? 'Neznámý tým',
                    'score' => $match['score'] ?? '0-0',
                    'home_score' => $match['home_score'] ?? '0',
                    'away_score' => $match['away_score'] ?? '0',
                    'status' => $match['periodTXT'] ?? 'Neznámý stav',
                    'league' => $match['country_leagues'] ?? 'Neznámá liga',
                    'start_time' => $startTime->toDateTimeString(),
                    'minutes' => $match['minutes'] ?? 0,
                ];
            }, $data, array_keys($data)));

        } catch (RequestException $e) {
            return [];
        }
    }

    public function getAllMatches()
    {
        try {
            $response = $this->client->request('GET', $this->apiUrl, [
                'headers' => [
                    'x-rapidapi-host' => 'football-betting-odds1.p.rapidapi.com',
                    'x-rapidapi-key' => $this->apiKey,
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            if (!isset($data) || empty($data)) {
                return [];
            }

            return array_map(function ($match, $id) {
                $startTime = isset($match['startTime'])
                    ? Carbon::createFromTimestampUTC($match['startTime'])->setTimezone('Europe/Prague')->toDateTimeString()
                    : null;

                return [
                    'id' => $id,
                    'home_team' => $match['home'] ?? 'Neznámý tým',
                    'away_team' => $match['away'] ?? 'Neznámý tým',
                    'score' => $match['score'] ?? '0-0',
                    'home_score' => $match['home_score'] ?? '0',
                    'away_score' => $match['away_score'] ?? '0',
                    'status' => $match['periodTXT'] ?? 'Neznámý stav',
                    'league' => $match['country_leagues'] ?? 'Neznámá liga',
                    'start_time' => $startTime,
                    'minutes' => $match['minutes'] ?? 0,
                ];
            }, $data, array_keys($data));
        } catch (RequestException $e) {
            return [];
        }
    }

    public function getMatchOdds($id)
    {
        try {
            $response = $this->client->request('GET', "https://football-betting-odds1.p.rapidapi.com/provider1/live/match/{$id}", [
                'headers' => [
                    'x-rapidapi-host' => 'football-betting-odds1.p.rapidapi.com',
                    'x-rapidapi-key' => $this->apiKey,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (!isset($data['odds']) || !is_array($data['odds'])) {
                return [];
            }

            $allowedBetTypes = [
                'home', 'draw', 'away',
                'total-goal-0', 'total-goal-1', 'total-goal-2', 'total-goal-3', 'total-goal-4', 'total-goal-5', 'total-goal-6',
                'total-goal-4+', 'total-goal-5+', 'total-goal-6+',
                'total-goal-0-1', 'total-goal-0-2', 'total-goal-0-3', 'total-goal-2-3', 'total-goal-3-4', 'total-goal-4-5',
                'home-total-goal-0', 'home-total-goal-1', 'home-total-goal-2', 'home-total-goal-3+',
                'away-total-goal-0', 'away-total-goal-1', 'away-total-goal-2', 'away-total-goal-3+',
                'over-0-5', 'over-1-5', 'over-2-5', 'over-3-5', 'over-4-5', 'over-5-5', 'over-6-5', 'over-7-5',
                'under-0-5', 'under-1-5', 'under-2-5', 'under-3-5', 'under-4-5', 'under-5-5', 'under-6-5', 'under-7-5'
            ];

            $betTypeNames = [
                'home' => 'Výhra domácích',
                'draw' => 'Remíza',
                'away' => 'Výhra hostů',
                'total-goal-0' => 'Celkově 0 gólů',
                'total-goal-1' => 'Celkově 1 gól',
                'total-goal-2' => 'Celkově 2 góly',
                'total-goal-3' => 'Celkově 3 góly',
                'total-goal-4' => 'Celkově 4 góly',
                'total-goal-5' => 'Celkově 5 gólů',
                'total-goal-6' => 'Celkově 6 gólů',
                'total-goal-4+' => 'Více než 4 góly',
                'total-goal-5+' => 'Více než 5 gólů',
                'total-goal-6+' => 'Více než 6 gólů',
                'total-goal-0-1' => '0-1 gólů',
                'total-goal-0-2' => '0-2 gólů',
                'total-goal-0-3' => '0-3 gólů',
                'total-goal-2-3' => '2-3 góly',
                'total-goal-3-4' => '3-4 góly',
                'total-goal-4-5' => '4-5 gólů',
                'home-total-goal-0' => 'Domácí 0 gólů',
                'home-total-goal-1' => 'Domácí 1 gól',
                'home-total-goal-2' => 'Domácí 2 góly',
                'home-total-goal-3+' => 'Domácí 3+ góly',
                'away-total-goal-0' => 'Hosté 0 gólů',
                'away-total-goal-1' => 'Hosté 1 gól',
                'away-total-goal-2' => 'Hosté 2 góly',
                'away-total-goal-3+' => 'Hosté 3+ góly',
                'over-0-5' => 'Více než 0.5 gólů',
                'over-1-5' => 'Více než 1.5 gólů',
                'over-2-5' => 'Více než 2.5 gólů',
                'over-3-5' => 'Více než 3.5 gólů',
                'over-4-5' => 'Více než 4.5 gólů',
                'over-5-5' => 'Více než 5.5 gólů',
                'over-6-5' => 'Více než 6.5 gólů',
                'over-7-5' => 'Více než 7.5 gólů',
                'under-0-5' => 'Méně než 0.5 gólů',
                'under-1-5' => 'Méně než 1.5 gólů',
                'under-2-5' => 'Méně než 2.5 gólů',
                'under-3-5' => 'Méně než 3.5 gólů',
                'under-4-5' => 'Méně než 4.5 gólů',
                'under-5-5' => 'Méně než 5.5 gólů',
                'under-6-5' => 'Méně než 6.5 gólů',
                'under-7-5' => 'Méně než 7.5 gólů'
            ];

            $filteredOdds = array_filter($data['odds'], function ($key) use ($allowedBetTypes) {
                return in_array($key, $allowedBetTypes);
            }, ARRAY_FILTER_USE_KEY);

            $startTime = isset($data['startTime'])
                ? Carbon::createFromTimestampUTC($data['startTime'])->setTimezone('Europe/Prague')->format('d.m.Y H:i')
                : 'Neznámý čas';

            return [
                'match_info' => [
                    'id' => $id,
                    'home_team' => $data['home'] ?? 'Neznámý tým',
                    'away_team' => $data['away'] ?? 'Neznámý tým',
                    'score' => $data['score'] ?? '0-0',
                    'status' => $data['periodTXT'] ?? 'Neznámý stav',
                    'league' => $data['country_leagues'] ?? 'Neznámá liga',
                    'start_time' => $startTime,
                    'minutes' => $data['minutes'] ?? 0,
                ],
                'odds' => array_map(function ($betType, $odd) use ($betTypeNames) {
                    return [
                        'bet_type' => $betTypeNames[$betType] ?? $betType,
                        'odd' => $odd,
                    ];
                }, array_keys($filteredOdds), $filteredOdds),
            ];
        } catch (RequestException $e) {
            return [];
        }
    }

    public function getLiveMatchesByDate($date)
    {
        $matches = $this->getLiveMatches();

        return collect($matches)->filter(function ($match) use ($date) {
            return Carbon::parse($match['start_time'])->toDateString() === $date->toDateString();
        });
    }

}
