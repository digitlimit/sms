<?php

namespace Digitlimit\Sms\Contracts;

interface Factory
{
    /**
     * Specify a driver
     *
     * @param null $driver
     * @return mixed
     */
    public function driver($driver = null);
}
