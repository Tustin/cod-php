<?php

namespace CallOfDuty\Api\Game;

use CallOfDuty\Client;

use CallOfDuty\Api\User;
use CallOfDuty\Api\AbstractApi;
use CallOfDuty\Api\GameInterface;
use CallOfDuty\Api\ModeInterface;

use CallOfDuty\Api\Game\BlackOps4\Multiplayer;
use CallOfDuty\Api\Game\BlackOps4\Zombies;
use CallOfDuty\Api\Game\BlackOps4\Blackout;

class BlackOps4 extends AbstractApi implements GameInterface
{
    private $user;

    public function __construct(Client $client, User $user = null) 
    {
        parent::__construct($client, 'https://www.callofduty.com/api/papi-client/crm/cod/v2/title/bo4/');

        $this->user = $user;
    }

    public function user() : ?User
    {
        return $this->user;
    }

    public function multiplayer() : ModeInterface
    {
        return new Multiplayer\Mode($this->client, $this);
    }

    public function zombies() : ModeInterface
    {
        return new Zombies\Mode($this->client, $this);
    }

    public function blackout() : ModeInterface
    {
        return new Blackout\Mode($this->client, $this);
    }
}