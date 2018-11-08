<?php

namespace CallOfDuty\Api\Game;

use CallOfDuty\Client;


class WWII extends AbstractApi implements GameInterface
{
    private $user;

    public function __construct(Client $client, User $user = null) 
    {
        parent::__construct($client, 'https://www.callofduty.com/api/papi-client/crm/cod/v2/title/wwii/');

        $this->user = $user;
    }

    public function stats() : object 
    {
        if ($this->user === null) return null;

        return $this->get(sprintf('platform/%s/gamer/%s/profile/', $this->user->platform(), $this->user->username()));
    }
}
