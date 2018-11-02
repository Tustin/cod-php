<?php

namespace CallOfDuty\Api;

use CallOfDuty\Client;

use CallofDuty\Game\BlackOps4;

class User extends AbstractApi 
{
    private $username;
    private $platform;

    public function __construct(Client $client, string $username, string $platform) 
    {
        parent::__construct($client);
        $this->username = $username;
        $this->platform = $platform;
    }

    public function platform() {
        return $this->platform;
    }

    public function username() {
        return $this->username;
    }

    public function bo4() : GameInterface
    {
        return new BlackOps4($this->client, $this);
    }
}