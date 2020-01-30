<?php

namespace Tustin\CallOfDuty\Api;

use GuzzleHttp\Client;
use Tustin\Haste\AbstractClient;

abstract class Api extends AbstractClient
{
    public function __construct(Client $client)
    {
        $this->httpClient = $client;
    }
}