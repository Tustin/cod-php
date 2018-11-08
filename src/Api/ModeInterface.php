<?php

namespace CallOfDuty\Api;

interface ModeInterface
{
    /**
     * Get weekly statistics.
     *
     * @return object
     */
    public function weekly() : StatInterface;

    /**
     * Get lifetime statistics.
     *
     * @return StatInterface
     */
    public function lifetime() : StatInterface;
}