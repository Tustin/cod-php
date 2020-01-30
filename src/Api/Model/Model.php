<?php

namespace Tustin\CallOfDuty\Api\Model;

use Tustin\CallOfDuty\Api\Api;


abstract class Model extends Api
{
    private ?object $cache = null;
}