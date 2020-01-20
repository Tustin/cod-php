<?php

namespace Tustin\CallOfDuty\Api;

use Tustin\CallOfDuty\Api\Model\Player;
use Tustin\CallOfDuty\Api\Enum\Platform;

class Friends extends Api
{

    public function all(int $limit = 0) : \Generator
    {
        $friends = $this->get();

        foreach ($friends->data->uno as $friend)
        {
            yield new Player($friend);
        }
    }
}