<?php

namespace CallOfDuty\Api\Game\BlackOps4;

class Map extends AbstractApi implements MapInterface
{
    public function __construct(Client $client) 
    {
        parent::__construct($client, 'https://www.callofduty.com/api/papi-client/crm/cod/v2/title/bo4/');

        $this->user = $user;
    }
}