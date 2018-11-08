<?php

namespace CallOfDuty\Api;

interface GameInterface
{
    /**
     * User checking stats of.
     *
     * @return User|null The user.
     */
    public function user() : ?User;
}