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

namespace Qodehub\Slydepay\Tests\Unit;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Qodehub\Slydepay\Config;
use Qodehub\Slydepay\Slydepay;

class Test extends TestCase
{
    /**
     * The configuration instance.
     * @var Config
     */
    protected $config;

    /**
     * This Package Version.
     *
     * @var string
     */
    protected $version = '1.0.0';
    /**
     * This will be the Authorization merchantKey
     *
     * @var string
     */
    protected $merchantKey = 'some-valid-merchantKey';
    /**
     * This is the emailOrMobileNumber for the Slydepay Merchant
     *
     * @var string
     */
    protected $emailOrMobileNumber = 1234567890;

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->emailOrMobileNumber, $this->merchantKey);
    }

    /** @test */
    public function the_package_version_is_v1()
    {
        $instance = new Slydepay();

        $this->assertSame($instance->getPackageVersion(), '1.0.0');
    }

    /** @test */
    public function the_configuration_can_be_passed_into_the_constructor()
    {
        $instance = new Slydepay($this->config);

        $this->assertEquals($instance->getConfig(), $this->config);
    }

    /** @test */
    public function a_valid_configuraiton_data_array_can_be_passed_into_the_constructor()
    {
        $config = [
            'emailOrMobileNumber' => $this->emailOrMobileNumber,
            'merchantKey' => $this->merchantKey,
        ];

        $instance = new Slydepay($config);

        $this->assertEquals($this->config, $instance->getConfig());
    }

    /** @test */
    public function an_instance_can_be_created_using_the_make_static_method()
    {
        $instance = Slydepay::make();

        $this->assertInstanceOf(Slydepay::class, $instance);
    }

    /** @test */
    public function a_new_instance_can_recive_the_configuration_parameters_as_arguements()
    {
        $instance = new Slydepay($this->emailOrMobileNumber, $this->merchantKey);

        $this->assertSame($instance->getConfig()->getEmailOrMobileNumber(), $this->emailOrMobileNumber);
        $this->assertSame($instance->getConfig()->getmerchantKey(), $this->merchantKey);
    }

    /** @test */
    public function the_version_on_the_configuration_instance_can_be_updated_from_the_bitgo_instance()
    {
        $instance = new Slydepay();

        $this->assertSame('1.0.0', $instance->getPackageVersion());

        /**
         * Change the version and see that it is the same.
         * @var string
         */
        $instance->setPackageVersion($newVersion = '3.0.0');

        $this->assertSame($newVersion, $instance->getPackageVersion());
    }

    /** @test */
    public function bad_method_calls_should_throw_a_badMethodCallException_error()
    {
        $instance = new Slydepay();

        $this->expectException(\BadMethodCallException::class);

        $instance->someRandomBadMethod();
    }
}
