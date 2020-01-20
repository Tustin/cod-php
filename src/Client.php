<?php
namespace Tustin\CallOfDuty;

use Tustin\CallOfDuty\Http\HttpClient;
use Tustin\CallOfDuty\Http\ResponseParser;
use Tustin\CallOfDuty\Http\TokenMiddleware;
use Tustin\CallOfDuty\Http\ResponseHandlerMiddleware;

use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\HandlerStack;

class Client extends HttpClient
{
    private array $guzzleOptions;

    private string $deviceId;
    private string $accessToken;

    public function __construct(array $guzzleOptions = [])
    {
        if (!isset($guzzleOptions['handler']))
        {
            $guzzleOptions['handler'] = HandlerStack::create();
        }

        // $guzzleOptions['allow_redirects'] = true;
        $guzzleOptions['cookies'] = true;

        $this->guzzleOptions = $guzzleOptions;

        $this->httpClient = new \GuzzleHttp\Client($this->guzzleOptions);

        $config  = $this->httpClient->getConfig();
        $handler = $config['handler'];

        $handler->push(
            Middleware::mapResponse(
                new ResponseHandlerMiddleware
            )
        );
    }

    /**
     * Create a new Client instance.
     *
     * @param array $guzzleOptions Guzzle options
     * @return \Tustin\CallOfDuty\Client
     */
    public static function create(array $guzzleOptions = []) : Client
    {
        return new static($guzzleOptions);
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

        $response = $this->postJson('registerDevice', [
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
        $this->postJson('login', [
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

        $this->pushTokenMiddleware();

        $this->submitLogin($email, $password);

        return $this;
    }

    /**
     * Pushes TokenMiddleware onto the HandlerStack with the necessary header information.
     *
     * @return void
     */
    private function pushTokenMiddleware() : void
    {
        $config  = $this->httpClient->getConfig();
        $handler = $config['handler'];

        $handler->push(
            Middleware::mapRequest(
                new TokenMiddleware($this->accessToken(), $this->deviceId())
            )
        );
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