<?php

namespace CallOfDuty\Api;

use CallOfDuty\Client;

use CallOfDuty\Api\Game\BlackOps4;

class User extends AbstractApi
{
    private $gamertag;
    private $platform;

    public function __construct(Client $client, string $gamertag, string $platform)
    {
        parent::__construct($client);
        $this->gamertag = $gamertag;
        $this->platform = $platform;
    }

    public function platform()
    {
        return $this->platform;
    }

    public function gamertag()
    {
        return $this->gamertag;
    }

    public function bo4() : GameInterface
    {
        return new BlackOps4($this->client, $this);
    }

    public function blackOps4() : GameInterface
    {
        return $this->bo4();
    }

    public function wwii() : GameInterface
    {
        return new WWII($this->client, $this);
    }
}