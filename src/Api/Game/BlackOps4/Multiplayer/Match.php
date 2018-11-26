<?php

namespace CallOfDuty\Api\Game\BlackOps4\Multiplayer;

use CallOfDuty\Client;

use CallOfDuty\Api\AbstractMatch;

class Match extends AbstractMatch 
{
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