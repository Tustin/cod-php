<?php

namespace Tustin\CallOfDuty\Api\Model;

use Tustin\CallOfDuty\Api\Model\Model;
use Tustin\CallOfDuty\Api\Enum\Platform;

class Player implements Model
{
    protected Platform $platform;

    protected string $username;
    
    private string $accountId;

    private string $avatarUrl;

    private bool $online;

    private array $identities;

    public function __construct(object $data)
    {
        $this->platform = new Platform($data->platform);
        $this->username = $data->username;
        $this->accountId = $data->accountId;
        $this->avatarUrl = $data->avatarUrlLargeSsl ?? $data->avatarUrlLarge ?? '';
        $this->online = (bool)$data->status->online ?? false;
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
}