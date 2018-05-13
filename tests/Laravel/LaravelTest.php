<?php
/**
 * @package     Qodehub\Slydepay
 * @link        https://github.com/qodehub/slydepay-php
 *
 * @author      Ariama O. Victor (ovac4u) <victorariama@qodehub.com>
 * @link        http://www.ovac4u.com
 *
 * @license     https://github.com/qodehub/slydepay-php/blob/master/LICENSE
 * @copyright   (c) 2018, QodeHub, Ltd
 */

namespace Qodehub\Slydepay\Tests\Laravel;

use Orchestra\Testbench\TestCase;
use Qodehub\Slydepay\Config;
use Qodehub\Slydepay\Laravel\Facades\Slydepay;
use Qodehub\Slydepay\Laravel\PackageServiceProvider;

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
        $app['config']->set('qodehub.slydepay.email-or-phone', 'emailOrMobileNumber@qodehub.com');
        $app['config']->set('qodehub.slydepay.merchant-key', 'someMerchantKey');
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
        $this->assertInstanceOf(Config::class, Slydepay::getConfig());
    }

    public function test_env_configuration()
    {
        $configInstance = Slydepay::getConfig();

        $this->assertSame($configInstance->getEmailOrMobileNumber(), 'emailOrMobileNumber@qodehub.com');
        $this->assertSame($configInstance->getMerchantKey(), 'someMerchantKey');
    }
}
