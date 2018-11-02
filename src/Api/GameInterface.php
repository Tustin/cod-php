<?php


namespace CallOfDuty\Api;


interface GameInterface 
{

    /**
     * Get statistics for a certain Call of Duty game.
     *
     * @return object The stats data.
     */
    public function stats() : object;

}