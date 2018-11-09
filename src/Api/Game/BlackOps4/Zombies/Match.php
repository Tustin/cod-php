<?php

namespace CallOfDuty\Api\Game\BlackOps4\Zombies;

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
}