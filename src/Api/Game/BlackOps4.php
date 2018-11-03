<?php

namespace CallOfDuty\Api\Game;

class BlackOps4 extends AbstractApi implements GameInterface
{
    const BASE_URL = 'https://my.callofduty.com/api/papi-client/crm/cod/v2/title/bo3/';

    private $user;

    public function __construct(Client $client, User $user = null)
    {
        parent::__construct($client);

        $this->user = $user;
    }

    public function stats() : object
    {
        if ($this->user === null) {
            return null;
        }

        return $this->get(sprintf(self::BASE_URL . 'platform/%s/gamer/%s/profile/', $this->user->platform(), $this->user->username()));
    }
}
