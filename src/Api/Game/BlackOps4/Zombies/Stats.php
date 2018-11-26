<?php
namespace CallOfDuty\Api\Game\BlackOps4\Zombies;

use CallOfDuty\Api\StatInterface;
use CallOfDuty\Api\MapInterface;
use CallOfDuty\Api\ModeInterface;


class Stats implements StatInterface
{
    private $stats;

    public function __construct(object $stats) 
    {
        $this->stats = $stats;
    }

    public function stats() : object
    {
        // Hack...
        return $this->stats->all ?? $this->stats;
    }

    public function map(string $name) : MapInterface
    {
        
    }

    public function maps() : array
    {

    }

    public function mode(string $name) : ModeInterface
    {

    }

    public function modes() : array
    {

    }

    public function kills() : int
    {
        return intval($this->stats()->kills ?? 0);
    }

    public function downs() : int
    {
        return intval($this->stats()->downs ?? 0);
    }

    public function headshots() : int
    {
        return intval($this->stats()->headshots ?? 0);
    }

    public function elixirsUsed() : int
    {
        return intval($this->stats()->bgbsChewed ?? 0);
    }

    public function revives() : int
    {
        return intval($this->stats()->revives ?? 0);
    }

    public function shieldsPurchased() : int
    {
        return intval($this->stats()->shieldsPurchased ?? 0);
    }

    public function timePlayed() : \DateInterval
    {
        return new \DateInterval(sprintf('PT%dS', intval($this->stats()->timePlayedTotal ?? 0)));
    }

    public function maxAmmosPickedUp() : int
    {
        return intval($this->stats()->fullAmmoPickedup ?? 0);
    }

    public function fireSalesPickedUp() : int
    {
        return intval($this->stats()->fireSalePickedup ?? 0);
    }

    public function doublePapKills() : int
    {
        return intval($this->stats()->doublePapKills ?? 0);
    }

    public function catalystKills() : int
    {
        return intval($this->stats()->catalystsKilled ?? 0);
    }

    public function dogsKilled() : int
    {
        return intval($this->stats()->zdogsKilled ?? 0);
    }

    public function mysteryBoxGrabs() : int
    {
        return intval($this->stats()->grabbedFromMagicbox ?? 0);
    }

    public function highestRound() : int
    {
        return intval($this->stats()->highestRoundReached ?? 0);
    }

    public function instaKillsPickedUp() : int
    {
        return intval($this->stats()->instaKillPickedup ?? 0);
    }

    public function gamesPlayed() : int
    {
        return intval($this->stats()->totalGamesPlayed ?? 0);
    }

    public function doorsPurchased() : int
    {
        return intval($this->stats()->doorsPurchased ?? 0);
    }

    public function perksDrank() : int
    {
        return intval($this->stats()->perksDrank ?? 0);
    }

    public function weaponsPacked() : int
    {
        return intval($this->stats()->usePap ?? 0);
    }

    public function wonderWeaponKills() : int
    {
        return intval($this->stats()->wonderWeaponKills ?? 0);
    }

    public function roundsSurvived() : int
    {
        return intval($this->stats()->totalRoundsSurvived ?? 0);
    }

    public function headshotPercentage($precision = 2) : float
    {
        return round(floatval($this->stats()->doorsPurchased ?? 0), $precision) * 100;
    }

    public function doublePointsPickedup() : int
    {
        return intval($this->stats()->doublePointsPickedup ?? 0);
    }

    public function roundsWithNoDowns() : int
    {
        return intval($this->stats()->roundsNoDowns ?? 0);
    }

    public function grenadeKills() : int
    {
        return intval($this->stats()->grenadeKills ?? 0);
    }

    public function nukesPickedUp() : int
    {
        return intval($this->stats()->nukePickedup ?? 0);
    }

    public function drops() : int
    {
        return intval($this->stats()->drops ?? 0);
    }

    public function novaCrawlersKilled() : int
    {
        return intval($this->stats()->novaCrawlersKilled ?? 0);
    }

    public function gladiatorsKilled() : int
    {
        return intval($this->stats()->gladiatorsKilled ?? 0);
    }

    public function fullPowersPickedUp() : int
    {
        return intval($this->stats()->heroWeaponPowerPickedup ?? 0);
    }

    public function blightfathersKilled() : int
    {
        return intval($this->stats()->blightfathersKilled ?? 0);
    }

    public function carptentersPickedUp() : int
    {
        return intval($this->stats()->carpenterPickedup ?? 0);
    }

    public function averageRoundsCompleted() : int
    {
        return intval(round(floatval($this->stats()->avgRoundsCompleted ?? 0)));
    }

    public function catalystTransformationsDenied() : int
    {
        return intval($this->stats()->catalystTransformationDenials ?? 0);
    }

    public function specialWeaponUsed() : int
    {
        return intval($this->stats()->specialWeaponUsed ?? 0);
    }

    public function maxedSpecialWeaponKills() : int
    {
        return intval($this->stats()->maxedSpecialWeaponKills ?? 0);
    }
}