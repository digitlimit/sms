<?php

namespace Digitlimit\Sms\Contracts;

use Illuminate\Support\Collection;

interface Sms
{

    /**
     * Send SMS
     *
     * @param $content
     * @param array $data
     * @param $callback
     * @return Sms
     */
    public function send($content, array $data=[], $callback) : Sms;

    public function message($content, array $data=[], $callback) : Sms;
}