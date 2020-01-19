<?php

namespace Tustin\CallOfDuty\Http;

use Tustin\CallOfDuty\Exception\InvalidClassException;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\Request;

use GuzzleHttp\Psr7\Response;

abstract class HttpClient
{
    protected $httpClient;

    protected static string $defaultEndpoint = 'https://www.callofduty.com/';
    protected static string $squadsEndpoint = 'https://squads.callofduty.com/';
    protected static string $profileEndpoint = 'https://profile.callofduty.com/';
    protected static string $myEndpoint = 'https://my.callofduty.com/';

    private Response $lastResponse;

    public function get(string $path = '', array $body = [], array $headers = []) : object
    {
        $this->resolve($path);

        // We're doing the query building here because Sony's API won't accept encoded query strings.
        // Unfortunately, Guzzle will automatically encode the query string and there's no way to disable it.
        // - Tustin 5/24/2019
        $path .= (strpos($path, '?') === false) ? '?' : '&';
        $path .= urldecode(http_build_query($body));

        return ($this->lastResponse = $this->httpClient->get($path, [
            'headers' => $headers
        ]))->getBody()->jsonSerialize();
    }

    public function post(string $path, array $body, array $headers = []) : object
    {
        $this->resolve($path);

        return ($this->lastResponse = $this->httpClient->post($path, [
            'form_params' => $body,
            'headers' => $headers
        ]))->getBody()->jsonSerialize();
    }

    public function postJson(string $path, array $body, array $headers = []) : object
    {
        $this->resolve($path);

        return ($this->lastResponse = $this->httpClient->post($path, [
            'json' => $body,
            'headers' => $headers
        ]))->getBody()->jsonSerialize();
    }

    public function postMultiPart(string $path, array $body, array $headers = []) : object
    {
        $this->resolve($path);

        return ($this->lastResponse = $this->httpClient->post($path, [
            'multipart' => $body,
            'headers' => $headers
        ]))->getBody()->jsonSerialize();
    }

    public function delete(string $path, array $headers = []) : object
    {
        $this->resolve($path);

        return ($this->lastResponse = $this->httpClient->delete($path, [
            'headers' => $headers
        ]))->getBody()->jsonSerialize();
    }

    public function patch(string $path, $body = null, array $headers = []) : object
    {
        $this->resolve($path);

        return ($this->lastResponse = $this->httpClient->patch($path, [
            'headers' => $headers
        ]))->getBody()->jsonSerialize();
    }

    public function put(string $path, $body = null, array $headers = []) : object
    {
        $this->resolve($path);

        return ($this->lastResponse = $this->httpClient->put($path, [
            'form_params' => $body,
            'headers' => $headers
        ]))->getBody()->jsonSerialize();
    }

    public function putJson(string $path, $body = null, array $headers = []) : object
    {
        $this->resolve($path);

        return ($this->lastResponse = $this->httpClient->put($path, [
            'json' => $body,
            'headers' => $headers
        ]))->getBody()->jsonSerialize();
    }

    public function putMultiPart(string $path, $body = null, array $headers = []) : object
    {
        $this->resolve($path);

        return ($this->lastResponse = $this->httpClient->put($path, [
            'multipart' => $body,
            'headers' => $headers
        ]))->getBody()->jsonSerialize();
    }

    public function lastResponse() : Response
    {
        return $this->lastResponse;
    }

    /**
     * Resolves a relative path to a full URL for any given class.
     *
     * @param string $path The relative path
     * @return void
     */
    private function resolve(string &$path) : void
    {
        // Just return the path since it's a complete URL.
        if (substr($path, 0, 4) === 'http')
        {
            return;
        }

        $class = get_class($this);

        switch ($class)
        {
            case \Tustin\CallOfDuty\Client::class:
                $path = static::$profileEndpoint . 'cod/mapp/' . $path;
            break;
            case \Tustin\CallOfDuty\Api\News::class:
                $path = static::$defaultEndpoint . 'site/cod/franchiseFeed/' . $path;
            break;
            case \Tustin\CallOfDuty\Api\Friends::class:
                $path = static::$myEndpoint . 'api/papi-client/userfeed/v1/friendFeed/rendered/en/';
            break;
            default:
                throw new InvalidClassException('HttpClient could not resolve a URL from class ' . $class);
        }
    }
}