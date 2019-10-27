<?php

namespace Digitlimit\Sms;

use Illuminate\Support\Arr;
use InvalidArgumentException;
use Illuminate\Support\Manager;
use Digitlimit\Sms\Providers\Google;
use Digitlimit\Sms\Providers\AbstractProvider;

class SmsManager extends Manager implements Contracts\Factory
{
    /**
     * Get a driver instance.
     *
     * @param  string  $driver
     * @return mixed
     */
    public function with($driver)
    {
        return $this->driver($driver);
    }

    /**
     * Create an instance of the specified driver.
     *
     * @return \Digitlimit\Sms\Providers\AbstractProvider
     */
    protected function createGoogleDriver() : AbstractProvider
    {
        $config = $config = $this->getDriverConfig('google');

        return $this->buildProvider(
            Google::class, $config
        );
    }

    /**
     * Build provider instance.
     *
     * @param  string  $provider
     * @param  array  $config
     * @return \Digitlimit\Sms\Providers\AbstractProvider
     */
    public function buildProvider($provider, $config)
    {
        return new $provider(
            $this->app['request'],
            $config['client_id'],
            Arr::get($config, 'guzzle', [])
        );
    }

    /**
     * Get the default driver name.
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        $config = $this->app['config']['sms'];

        if(is_array($config) && isset($config['defaults']) && $config['defaults']['driver']){
            return $config['defaults']['driver'];
        }

        throw new InvalidArgumentException('No Sms driver as specified or configured');
    }

    /**
     * Get the sms config
     *
     * @param $driver
     * @return mixed
     */
    protected function getDriverConfig($driver){

        $config = $this->app['config']['sms'];

        if(is_array($config) && isset($config['providers']) && $config['providers'][$driver]){
            return $config['providers'][$driver];
        }

        throw new InvalidArgumentException('No driver found for '. $driver);
    }

}
