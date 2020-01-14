<?php

namespace Tustin\CallOfDuty\Exception;

use Tustin\CallOfDuty\Http\JsonStream;

class CallOfDutyApiException extends \Exception
{
    public function __construct(JsonStream $stream)
    {
        $data = $stream->jsonSerialize();

        $message = 'Temp';
        $code = 69;

        if (isset($message, $code))
        {
            parent::__construct($message, $code);
        }
    }
}