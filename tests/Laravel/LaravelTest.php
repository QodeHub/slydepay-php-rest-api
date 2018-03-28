<?php

/**
 * @package     OVAC/Laravel-Hubtel-Payment
 * @link        https://github.com/ovac/laravel-hubtel-payment
 *
 * @author      Ariama O. Victor (OVAC) <contact@ovac4u.com>
 * @link        http://ovac4u.com
 *
 * @license     https://github.com/ovac/laravel-hubtel-payment/blob/master/LICENSE
 * @copyright   (c) 2017, RescopeNet, Inc
 */

namespace OVAC\LaravelHubtelPayment\Tests;

use Orchestra\Testbench\TestCase;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\Laravel\Facades\Bitgo;
use Qodehub\Bitgo\Laravel\PackageServiceProvider;

class LaravelTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('qodehub.bitgo.host', 'testhost.run');
        $app['config']->set('qodehub.bitgo.token', 'testtoken');
        $app['config']->set('qodehub.bitgo.secure', true);
        $app['config']->set('qodehub.bitgo.port', 1234);
    }

    /**
     * Get the package provider
     * @param  Container $app
     * @return array[PackageServiceProvider::class]
     */
    protected function getPackageProviders($app)
    {
        return [PackageServiceProvider::class];
    }

    /** @test */
    public function the_getConfig_method_should_receive_a_config_instance()
    {
        $this->assertInstanceOf(Config::class, Bitgo::btc()->getConfig());
    }

    public function test_env_configuration()
    {
        $configInstance = Bitgo::getConfig();

        $this->assertSame($configInstance->getToken(), 'testtoken');
        $this->assertSame($configInstance->getHost(), 'testhost.run');
        $this->assertSame($configInstance->isSecure(), true);
        $this->assertSame($configInstance->getPort(), 1234);
    }
}
