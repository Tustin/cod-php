<?php

namespace Tustin\CallOfDuty\Http;

use GuzzleHttp\Psr7\Request;

final class TokenMiddleware
{
    private $accessToken;
    private $deviceId;

    public function __construct(string $accessToken, string $deviceId)
    {
        $this->accessToken = $accessToken;
        $this->deviceId = $deviceId;
    }

    public function __invoke(Request $request, array $options = [])
    {
        return $request
        ->withHeader(
            'Authorization', sprintf('Bearer %s', $this->accessToken)
        )
        ->withHeader('x_cod_device_id', $this->deviceId);
    }
}