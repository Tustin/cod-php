<?php

namespace CallOfDuty\Api;

use CallOfDuty\Client;

abstract class AbstractMatch extends AbstractApi implements MatchInterface
{
    protected $id;
    protected $data;

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
}