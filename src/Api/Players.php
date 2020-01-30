<?php


namespace Tustin\CallOfDuty\Api;

use Tustin\CallOfDuty\Api\Model\Player;
use Tustin\CallOfDuty\Api\Enum\Platform;


class Players extends Api
{
    public function search(string $username, Platform $platform) : \Generator
    {
        $players = $this->get("/crm/cod/v2/platform/$platform/username/$username/search");

        foreach ($players->data as $player)
        {
            yield new Player($this->httpClient, $player);
        }
    }

    public function find(string $username, Platform $platform) : Player
    {
        return new Player($this->httpClient, [
            'username' => $username,
            'platform' => $platform
        ]);
    }
}