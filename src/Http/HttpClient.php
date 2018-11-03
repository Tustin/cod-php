<?php

namespace CallOfDuty\Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\Response;

class HttpClient 
{
    private $client;

    // Flags
    const FORM  = 1;
    const JSON  = 2;
    const MULTI = 4;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function get(string $path, array $body = [], array $headers = [], $options = [])
    {
        $response = $this->request('GET', $path, $body, self::FORM, $headers, $options);

        return ResponseParser::parse($response);
    }

    public function post(string $path, $body, int $type = self::FORM, array $headers = [], $options = [])
    {
        $response = $this->request('POST', $path, $body, $type, $headers, $options);

        return ResponseParser::parse($response);
    }

    public function delete(string $path, array $headers = [], $options = [])
    {
        $response = $this->request('DELETE', $path, null, self::FORM, $headers, $options);

        return ResponseParser::parse($response);
    }

    public function patch(string $path, $body = null, int $type = self::FORM, array $headers = [], $options = [])
    {
        $response = $this->request('PATCH', $path, $body, $type, $headers, $options);

        return ResponseParser::parse($response);
    }

    public function put(string $path, $body = null, int $type = self::FORM, array $headers = [], $options = [])
    {
        $response = $this->request('PUT', $path, $body, $type, $headers, $options);

        return ResponseParser::parse($response);
    }

    private function request(string $method, string $path, $body = null, int $type = self::FORM, array $headers = [], $options = [])
    {
        $requestOptions = [];

        if ($method === 'GET' && $body != null) {
            $path .= (strpos($path, '?') === false) ? '?' : '&';
            $path .= urldecode(http_build_query($body));
        } else {
            if ($type & self::FORM) {
                $requestOptions["form_params"] = $body;
            } else if ($type & self::JSON) {
                $requestOptions["json"] = $body;
            } else if ($type & self::MULTI) {
                $requestOptions['multipart'] = $body;
            }
        }

        $requestOptions['headers'] = $headers;
        $requestOptions['allow_redirects'] = false;

        $options = array_merge($requestOptions, $options);

        try {
            return $this->client->request($method, $path, $options);
        } catch (GuzzleException $e) {
            throw $e;
        }
    }
}
