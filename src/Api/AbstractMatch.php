<?php

namespace CallOfDuty\Api;

use CallOfDuty\Client;

abstract class AbstractMode extends AbstractApi
{
    protected $game;
    protected $mode;

    public function __construct(GameInterface $game, string $mode)
    {
        $this->game = $game;
        $this->mode = $mode;
    }

    /**
     * Gets a user's matches for a mode.
     *
     * @return array Match data.
     */
    public function matches() : array
    {
        return $this->game->get(
            sprintf(
                'platform/%s/gamer/%s/matches/%s/start/0/end/0/details', 
                $this->game->user()->platform(),
                $this->game->user()->gamertag(),
                $this->mode
            )
        )->data->matches;
    }
}