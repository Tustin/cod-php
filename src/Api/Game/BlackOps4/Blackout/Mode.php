<?php

namespace CallOfDuty\Api\Game\BlackOps4\Blackout;

use CallOfDuty\Client;

use CallOfDuty\Api\AbstractMode;
use CallOfDuty\Api\GameInterface;
use CallOfDuty\Api\StatInterface;

use CallOfDuty\Api\Game\BlackOps4\Blackout\Stats;
use CallOfDuty\Api\Game\BlackOps4\Blackout\Match;

class Mode extends AbstractMode
{
    protected $game;

    protected $mode = 'wz';

    public function __construct(Client $client, GameInterface $game) 
    {
        $this->game = $game;

        parent::__construct($client, $this->game, $this->mode);
    }

    public function recentMatches()
    {
        return $this->matches(Match::class);
    }

    public function lifetime() : StatInterface
    {
        return new Stats($this->stats()->lifetime);
    }

    public function weekly() : StatInterface
    {
        return new Stats($this->stats()->weekly);
    }

    public function level() : int
    {
        return intval($this->stats()->level ?? 0);
    }

    public function echelon() : int
    {
        return $this->level();
    }
}