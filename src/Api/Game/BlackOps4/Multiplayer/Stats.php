<?php

namespace CallOfDuty\Api\Game\BlackOps4\Multiplayer;

use CallOfDuty\Api\StatInterface;

class Stats implements StatInterface
{
    private $stats;

    public function __construct(object $stats) 
    {
        $this->stats = $stats;
    }

    public function stats() : object
    {
        return $this->stats;
    }

    public function ekia() : int
    {
        return intval($this->stats()->ekia ?? 0);
    }

    public function deaths() : int
    {
        return intval($this->stats()->deaths ?? 0);
    }

    public function wins() : int
    {
        return intval($this->stats()->wins ?? 0);
    }

    public function ekiaDeathRatio(int $precision = 2) : float
    {
        return round(floatval($this->stats()->ekiadRatio ?? 0), $precision);
    }

    public function scorePerMinute($precision = 2) : float
    {
        return round(floatval($this->stats()->scorePerMinute ?? 0), $precision);
    }
}