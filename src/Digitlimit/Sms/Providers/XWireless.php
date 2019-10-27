<?php
namespace Digitlimit\Sms\Providers;

use Digitlimit\Sms\Contracts\Sms as SmsContract;
use Illuminate\Support\Collection;
use Closure;
use Digitlimit\Sms\Exceptions\InvalidMessageCallbackException;

class XWireless extends AbstractProvider implements SmsContract
{
    /**
     * Send SMS
     *
     * @param $content
     * @param array $data
     * @param $callback
     * @return SmsContract
     */
    public function send($content, array $data=[], $callback) : SmsContract
    {
        //TODO implement send
    }

    public function message($content, array $data=[], $callback) : SmsContract
    {
        //TODO implement send
    }

    /**
     * Get API Base Url
     *
     * @param null $path
     * @return string
     */
    protected function getBaseUrl($path=null) : string
    {
        $url = "http://panel.xwireless.net/API/WebSMS/Http/v1.0a/index.php";
        return $path ? $url . "/" . $path : $url;
    }

    protected function buildCallbackMessage($callback)
    {
        if($callback instanceof Closure){
            return call_user_func($callback, $this);
        }

        throw new InvalidMessageCallbackException('Callback is not valid');
    }

}