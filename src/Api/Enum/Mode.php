<?php
namespace Tustin\CallOfDuty\Api\Enum;

use MyCLabs\Enum\Enum;

class Mode extends Enum
{
    private const MULTIPLAYER = 'mp';
    private const ZOMBIES = 'zm';
    private const BLACKOUT = 'wz';
    // TODO: MW BR
}