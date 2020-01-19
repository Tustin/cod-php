<?php

namespace Tustin\CallOfDuty\Api;

class Friends extends Api
{
    /**
     * Get all friends.
     *
     * @return object
     */
    public function all(int $limit = 0) : object
    {
        $friends = $this->get();

        return $friends;
    }
}