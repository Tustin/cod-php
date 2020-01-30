<?php
namespace Tustin\CallOfDuty;

use GuzzleHttp\Middleware;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Cookie\CookieJar;
use Tustin\Haste\AbstractClient;
use Tustin\Haste\Http\Middleware\AuthenticationMiddleware;

class Client extends AbstractClient
{
    private string $deviceId;
    private string $accessToken;

    public function __construct(array $guzzleOptions = [])
    {
        // I really should have a better way of doing this
        $guzzleOptions['base_uri'] = 'https://www.callofduty.com/api/papi-client/';
        if (!isset($guzzleOptions['cookies']))
        {
            $guzzleOptions['cookies'] = true;
        }

        parent::__construct($guzzleOptions);
    }

    /**
     * Generates and registers a device ID.
     * 
     * This is required for logging into the Call of Duty API.
     *
     * @return void
     */
    public function registerDevice() : void
    {
        $this->deviceId = md5(uniqid());

        $response = $this->postJson('https://profile.callofduty.com/cod/mapp/registerDevice', [
            'deviceId' => $this->deviceId
        ]);

        $this->accessToken = $response->data->authHeader;
    }

    /**
     * Finalizes the login flow.
     *
     * @param string $email Activision email
     * @param string $password Activision password
     * @return void
     */
    public function submitLogin(string $email, string $password) : void
    {
        $this->postJson('https://profile.callofduty.com/cod/mapp/login', [
            'email' => $email,
            'password' => $password
        ]);
    }
    
    /**
     * Login to the Call of Duty API.
     *
     * @param string $email Activision email
     * @param string $password Activision password
     * @return Client
     */
    public function login(string $email, string $password) : Client
    {
        $this->registerDevice();

        $this->pushAuthenticationMiddleware(new AuthenticationMiddleware([
            'Authorization' => 'Bearer ' . $this->accessToken(),
            'x_cod_device_id' => $this->deviceId()
        ]));

        $this->submitLogin($email, $password);

        return $this;
    }

    /**
     * Gets the access token for the account.
     *
     * @return string
     */
    public function accessToken() : string
    {
        return $this->accessToken;
    }

    /**
     * Gets the generated device Id for this instance.
     *
     * @return string
     */
    public function deviceId() : string
    {
        return $this->deviceId;
    }

    public function __call($method, array $parameters)
    {
        $class = "\\Tustin\\CallOfDuty\\Api\\" . ucwords($method);

        if (class_exists($class))
        {
            return new $class($this->httpClient);
        }

        throw new \BadMethodCallException("Undefined method [{$method}] called.");
    }
}