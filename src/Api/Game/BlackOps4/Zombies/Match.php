<?php

namespace CallOfDuty\Api\Game\BlackOps4\Zombies;

use CallOfDuty\Client;

use CallOfDuty\Api\AbstractMatch;

use CallOfDuty\Api\StatInterface;

class Match extends AbstractMatch 
{
    public function downs() : int
    {
        return intval($this->info()->downCount ?? 0);
    }

    public function difficultyId() : int
    {
        return intval($this->info()->difficulty ?? 0);
    }

    public function difficulty() : string
    {
        switch ($this->difficultyId())
        {
            case 0:
            return 'Casual';
            case 1:
            return 'Normal';
            case 2:
            return 'Hardcore';
            case 3:
            return 'Realistic';
            default:
            return '';
        }
    }

    public function roundReached() : int
    {
        return intval($this->info()->numZombieRounds ?? 0);
    }

    public function playerCount() : int
    {
        return intval($this->info()->playerCount ?? 0);
    }

    public function playerStats() : StatInterface
    {
        return new Stats($this->info()->playerStats);
    }
}