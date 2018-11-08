<?php

namespace CallOfDuty\Api\Game\BlackOps4\Mode;

use CallOfDuty\Client;

use CallOfDuty\Api\AbstractApi;
use CallOfDuty\Api\ModeInterface;
use CallOfDuty\Api\GameInterface;
use CallOfDuty\Api\StatInterface;


use CallOfDuty\Api\Game\BlackOps4\Stat;
use CallOfDuty\Api\Game\BlackOps4\Match;

class Multiplayer extends AbstractApi implements ModeInterface
{
    private $stats;
    private $game;

    public function __construct(Client $client, GameInterface $game) 
    {
        $this->game = $game;
    }

    public function stats() : object
    {
        if ($this->stats === null) {
            $this->stats = $this->game->get(
                sprintf(
                    'platform/%s/gamer/%s/profile/type/mp', 
                    $this->game->user()->platform(),
                    $this->game->user()->gamertag()
                )
            )->data->mp;
        }
        
        return $this->stats;
    }

    public function matches() : array
    {
        $returnMatches = [];
        // The start and end args don't seem to actually do anything.
        // Using other numbers will most likely error it out and -1 still returns 20 matches.
        $matches = $this->game->get(
            sprintf(
                'platform/%s/gamer/%s/matches/mp/start/0/end/0/details', 
                $this->game->user()->platform(),
                $this->game->user()->gamertag()
            )
        )->data->matches;

        foreach ($matches as $match) {
            $returnMatches[] = new Match($match->matchID, $match);
        }

        return $returnMatches;
    }

    public function lifetime() : StatInterface
    {
        return new Stat\Multiplayer($this->stats()->lifetime);
    }

    public function weekly() : StatInterface
    {
        return new Stat\Multiplayer($this->stats()->weekly);
    }

    public function level() : int
    {
        return intval($this->stats()->level ?? 0);
    }

    public function prestige() : int
    {
        return intval($this->stats()->prestige ?? 0);
    }
}