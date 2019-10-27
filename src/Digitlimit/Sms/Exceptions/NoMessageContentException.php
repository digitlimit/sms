<?php

namespace Digitlimit\Sms\Exceptions;
use Exception;

/**
 * Throw an exception for no message content
 */
class NoMessageContentException extends Exception
{
    public function __construct($message, $code, Exception $previous)
    {
        parent::__construct($message, $code, $previous);
    }
}
