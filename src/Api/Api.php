<?php

namespace Tustin\CallOfDuty\Api;

use Tustin\CallOfDuty\Http\HttpClient;

abstract class Api extends HttpClient
{
    public function __construct(\GuzzleHttp\Client $client)
    {
        $this->httpClient = $client;
    }
}