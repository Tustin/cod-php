<?php

namespace CallOfDuty\Api\Game\BlackOps4\Blackout;

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

    public function eliminations() : int
    {
        return intval($this->stats()->killsEliminated ?? 0);
    }

    public function revives() : int
    {
        return intval($this->stats()->revives ?? 0);
    }

    public function killsWithoutDamage() : int
    {
        return intval($this->stats()->killsWithoutDamage ?? 0);
    }

    public function equipmentKills() : int
    {
        return intval($this->stats()->killsEquipment ?? 0);
    }

    public function totalDamage() : int
    {
        return intval($this->stats()->totalDamage ?? 0);
    }

    public function itemsPickedUp() : int
    {
        return intval($this->stats()->itemsPickedUp ?? 0);
    }

    public function healthItemsUsed() : int
    {
        return intval($this->stats()->itemsHealthUsed ?? 0);
    }

    public function damagePerGame() : int
    {
        return intval($this->stats()->damagePerGame ?? 0);
    }

    public function downs() : int
    {
        return intval($this->stats()->downs ?? 0);
    }

    public function zombieKills() : int
    {
        return intval($this->stats()->killsZombie ?? 0);
    }

    public function headshots() : int
    {
        return intval($this->stats()->headshots ?? 0);
    }

    public function supplyDropsOpened() : int
    {
        return intval($this->stats()->cargoSupplyOpened ?? 0);
    }  
}