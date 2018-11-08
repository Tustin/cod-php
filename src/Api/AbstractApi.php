<?php

namespace CallOfDuty\Api;

use CallOfDuty\Client;
use CallOfDuty\Http\HttpClient;
use CallOfDuty\Http\ResponseParser;

abstract class AbstractApi
{
    protected $client;
    protected $url;

    public function __construct(Client $client, string $url = '') 
    {
        $this->client = $client;
        $this->url = $url;
    }

    public function get(string $endpoint, array $parameters = [], array $headers = []) 
    {
        return $this->client->httpClient()->get($this->url . $endpoint, $parameters, $headers);
    }

    public function post(string $endpoint, $parameters, array $headers = []) 
    {
        return $this->client->httpClient()->post($this->url . $endpoint, $parameters, HttpClient::FORM, $headers);
    }

    public function postJson(string $endpoint, $parameters, array $headers = []) 
    {
        return $this->client->httpClient()->post($this->url . $endpoint, $parameters, HttpClient::JSON, $headers);
    }

    public function postMultiPart(string $endpoint, array $parameters, array $headers = [])
    {
        return $this->client->httpClient()->post($this->url . $endpoint, $parameters, HttpClient::MULTI, $headers);
    }

    public function delete(string $endpoint, array $headers = []) 
    {
        return $this->client->httpClient()->delete($this->url . $endpoint, $headers);
    }

    public function patch(string $endpoint, $parameters, array $headers = [])
    {
       return $this->client->httpClient()->patch($this->url . $endpoint, $parameters, HttpClient::FORM, $headers);
    }

    public function patchJson(string $endpoint, $parameters, array $headers = [])
    {
        return $this->client->httpClient()->patch($this->url . $endpoint, $parameters, HttpClient::JSON, $headers);
    }

    public function put(string $endpoint, $parameters, array $headers = [])
    {
        return $this->client->httpClient()->put($this->url . $endpoint, $parameters, HttpClient::FORM, $headers);
    }

    public function putJson(string $endpoint, $parameters, array $headers = [])
    {
        return $this->client->httpClient()->put($this->url . $endpoint, $parameters,  HttpClient::JSON, $headers);       
    }

    public function putMultiPart(string $endpoint, array $parameters, array $headers = [])
    {
        return $this->client->httpClient()->put($this->url . $endpoint, $parameters, HttpClient::MULTI, $headers);
    }
}
