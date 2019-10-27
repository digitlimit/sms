<?php

namespace Digitlimit\Sms\Facades;
use Illuminate\Support\Facades\Facade;
use Digitlimit\Sms\Contracts\Factory;

class Sms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}