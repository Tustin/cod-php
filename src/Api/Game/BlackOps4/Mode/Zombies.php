<?php

namespace CallOfDuty\Api\Game\BlackOps4\Mode;

use CallOfDuty\Client;

use CallOfDuty\Api\AbstractApi;
use CallOfDuty\Api\ModeInterface;
use CallOfDuty\Api\GameInterface;
use CallOfDuty\Api\StatInterface;

use CallOfDuty\Api\Game\BlackOps4\Stat;

class Zombies extends AbstractApi implements ModeInterface
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
                    'platform/%s/gamer/%s/profile/type/zm', 
                    $this->game->user()->platform(),
                    $this->game->user()->gamertag()
                )
            )->data->mp;
        }
        
        return $this->stats;
    }

    public function lifetime() : StatInterface
    {
        return new Stat\Zombies($this->stats()->lifetime);
    }

    public function weekly() : StatInterface
    {
        return new Stat\Zombies($this->stats()->weekly);
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