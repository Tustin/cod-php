<?php

namespace CallOfDuty\Api;

use CallOfDuty\Client;

use CallOfDuty\Api\MatchInterface;

abstract class AbstractMode extends AbstractApi implements ModeInterface
{
    protected $game;
    protected $mode;

    protected $stats;

    public function __construct(Client $client, GameInterface $game, string $mode)
    {
        parent::__construct($client);

        $this->game = $game;
        $this->mode = $mode;
    }

    public function stats() : object
    {
        if ($this->stats === null) {
            $this->stats = $this->game->get(
                sprintf(
                    'platform/%s/gamer/%s/profile/type/%s', 
                    $this->game->user()->platform(),
                    $this->game->user()->gamertag(),
                    $this->mode
                )
            )->data->mp;
        }
        
        return $this->stats;
    }

    public function matches(string $matchClass) : array
    {
        $returnMatches = [];

        // The start and end args don't seem to actually do anything.
        // Using other numbers will most likely error it out and -1 still returns 20 matches.
        $matches = $this->game->get(
            sprintf(
                'platform/%s/gamer/%s/matches/%s/start/0/end/0/details', 
                $this->game->user()->platform(),
                $this->game->user()->gamertag(),
                $this->mode
            )
        )->data->matches;

        foreach ($matches as $match) {
            $returnMatches[] = new $matchClass($match->matchID, $match);
        }

        return $returnMatches;
    }
}