<?php

namespace CallOfDuty\Api;

interface StatInterface
{
    /**
     * Get statistics for a map.
     *
     * @param string $name Internal map name.
     * @return MapInterface Map object.
     */
    public function map(string $name) : MapInterface;

    /**
     * Get statistics for all maps.
     *
     * @return array Array of Api\MapInterface.
     */
    public function maps() : array;

    /**
     * Get statistics for a mode.
     *
     * @param string $name Internal mode name.
     * @return ModeInterface Mode object.
     */
    public function mode(string $name) : ModeInterface;

    /**
     * Get statistics for all modes.
     *
     * @return array Array of Api\ModeInterface.
     */
    public function modes() : array;
}