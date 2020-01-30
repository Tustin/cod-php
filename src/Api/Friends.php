<?php

namespace Tustin\CallOfDuty\Api;

use Tustin\CallOfDuty\Api\Model\Player;
use Tustin\CallOfDuty\Api\Enum\Platform;

class Friends extends Api
{
    private ?object $cache = null;

    public function all() : \Generator
    {
        $friends = $this->raw();

        foreach ($friends->uno as $friend)
        {
            yield new Player($friend);
        }
    }

    public function requests() : \Generator
    {
        $friends = $this->raw();

        foreach ($friends->incomingInvitations as $invite)
        {
            yield new Player($invite);
        }
    }

    private function raw() : object
    {
        return $this->cache ??= $this->get()->data;
    }
}