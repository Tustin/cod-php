<?php

namespace CallOfDuty\Api\Game\BlackOps4\Multiplayer;

use CallOfDuty\Client;

use CallOfDuty\Api\MatchInterface;

class Match implements MatchInterface 
{
    private $id;
    private $data;

    public function __construct(string $matchId, object $matchData = null)
    {
        $this->id = $matchId;
        $this->data = $matchData;
    }

    public function info() : ?object
    {
        // For now, I can't seem to find an endpoint that just takes a matchId and gives me the same properties as the matches played endpoint.
        // It might not exist right now, but eventually I'd like to be able to grab match information just using the matchId.
        return $this->data;
    }

    public function start() : \DateTime
    {
        return new \DateTime($this->info()->utcStartSeconds);
    }

    public function end() : \DateTime
    {
        return new \DateTime($this->info()->utcEndSeconds);
    }

    public function map() : string
    {
        return $this->info()->map ?? '';
    }

    public function mode() : string
    {
        return $this->info()->mode ?? '';
    }

    public function id() : string
    {
        return $this->info()->matchID ?? '';
    }

    public function duration() : \DateInterval
    {
        return new \DateInterval(sprintf('PT%dS', intval($this->info()->duration ?? 0)));
    }

    public function result() : string
    {
        return $this->info()->result ?? '';
    }

    public function winningTeam() : string
    {
        return $this->info()->winningTeam ?? '';
    }

    public function gameBattle() : bool
    {
        return $this->info()->gameBattle ?? false;
    }

    public function arena() : bool
    {
        return $this->info()->arena ?? false;
    }

    public function privateMatch() : bool
    {
        // Not sure if this even works properly.
        return $this->info()->privateMatch ?? false;
    }

    public function team1Score() : int
    {
        return intval($this->info()->team1Score ?? 0);
    }

    public function team2Score() : int
    {
        return intval($this->info()->team2Score ?? 0);
    }

    public function kills() : int
    {
        return intval($this->info()->playerStats->kills ?? 0);
    }
}