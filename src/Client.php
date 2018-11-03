<?php
namespace CallOfDuty;

use CallOfDuty\Http\HttpClient;
use CallOfDuty\Http\ResponseParser;
use CallOfDuty\Api\User;
use CallOfDuty\Api\Squad;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Cookie\CookieJar;

class Client 
{
    const AUTH_API              = 'https://profile.callofduty.com/cod/mapp/login';
    const REGISTER_DEVICE_API   = 'https://profile.callofduty.com/cod/mapp/registerDevice';

    private $httpClient;
    private $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->httpClient = new HttpClient(new \GuzzleHttp\Client($this->options));
    }
    
    /**
     * Login to the Call of Duty website.
     *
     * @param string $email COD email.
     * @param string $password COD password.
     * @return void
     */
    public function login(string $email, string $password)
    {
        // Setup cookies for the site.
        $cookieJar = CookieJar::fromArray([
            'new_SiteId' => 'cod',
            'ACT_SSO_LOCALE' => 'en_US',
            'country' => 'US',
            'XSRF-TOKEN' => '4954d043-adfb-407e-ac8f-0f194cff95de',
        ], 'profile.callofduty.com');

        // We need to give the API some device Id to get an OAuth bearer token.
        // No verification is done on the device Id.
        $deviceId = md5(uniqid());

        $response = $this->httpClient()->post(self::REGISTER_DEVICE_API, [
            'deviceId' => $deviceId,
        ], HttpClient::JSON, [], [
            'cookies' => $cookieJar
        ]);

        $bearer = $response->data->authHeader;

        $response = $this->httpClient()->post(self::AUTH_API, [
            'email' => $email,
            'password' => $password,
        ], HttpClient::JSON, [
            'Authorization' => 'bearer ' . $bearer,
            'x_cod_device_id' => $deviceId
        ], [
            'cookies' => $cookieJar
        ]);

        return $this;
    }

    /**
     * Gets the HttpClient.
     *
     * @return HttpClient
     */
    public function httpClient() : HttpClient
    {
        return $this->httpClient;
    }

    public function user(string $username, string $platform) : User
    {
        return new User($this, $username, $platform);
    }

    public function squad(string $name) : Squad
    {
        return new Squad($this, $name);
    }
}
