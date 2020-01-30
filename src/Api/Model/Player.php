<?php

namespace Tustin\CallOfDuty\Api\Model;

use GuzzleHttp\Client;
use Tustin\CallOfDuty\Api\Enum\Mode;
use Tustin\CallOfDuty\Api\Enum\Title;

use Tustin\CallOfDuty\Api\Model\Model;
use Tustin\CallOfDuty\Api\Enum\Platform;

class Player extends Model
{
    protected Platform $platform;

    protected string $username;
    
    private string $accountId;

    private string $avatarUrl;

    private bool $online;

    private array $identities;

    public function __construct(Client $client, object $data)
    {
        parent::__construct($client);
        $this->platform = new Platform($data->platform);
        $this->username = $data->username;
        $this->encodedUsername = urlencode($this->username);
        $this->accountId = $data->accountId;
        $this->avatarUrl = $data->avatarUrlLargeSsl ?? $data->avatarUrlLarge ?? '';
        $this->online = $data->status->online ?? false;
    }

    public function platform() : Platform
    {
        return $this->platform;
    }

    public function username() : string
    {
        return $this->username;
    }

    public function accountId() : string
    {
        return $this->accountId;
    }

    public function avatarUrl() : string
    {
        return $this->avatarUrl;
    }

    public function online() : bool
    {
        return $this->avatarUrl;
    }

    /**
     * Gets the current player's recent matches.
     *
     * @param Title $title
     * @param Mode $mode
     * @param integer $limit
     * @param integer $startTimestamp
     * @param integer $endTimestamp
     * @return \Generator
     */
    public function matches(Title $title, Mode $mode, int $limit = 10, int $startTimestamp = 0, int $endTimestamp = 0) : \Generator
    {
        $matches = $this->get("crm/cod/v2/title/$title/platform/$this->platform/gamer/$this->encodedUsername/matches/$mode/start/$startTimestamp/end/$endTimestamp", [
            'limit' => $limit
        ]);

        foreach ($matches->data as $match)
        {
            yield $match;
        }
    }

    /**
     * Get the current player's profile for a specific Call of Duty title.
     *
     * @param Title $title
     * @param Mode $mode
     * @return object
     */
    public function profile(Title $title, Mode $mode) : object
    {
        return $this->cache ??= $this->get("stats/cod/v1/title/$title/platform/$this->platform/gamer/$this->encodedUsername/profile/type/$mode");
    }
}