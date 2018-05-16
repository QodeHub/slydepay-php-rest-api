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

use PHPUnit\Framework\TestCase;
use Qodehub\Slydepay\Config;
use Qodehub\Slydepay\Slydepay;

class ConfigTest extends TestCase
{
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
     * This is the emailOrPhoneNumber for the Bitgo Server
     *
     * @var string
     */
    protected $emailOrPhoneNumber = 1234567890;

    /** @test */
    public function a_new_config_config_can_be_created_with_valid_arguements()
    {
        $config = new Config($this->emailOrPhoneNumber, $this->merchantKey);

        $this->assertSame($config->getEmailOrMobileNumber(), $this->emailOrPhoneNumber);
        $this->assertSame($config->getmerchantKey(), $this->merchantKey);

        return $config;
    }

    /** @test */
    // public function test_the_config_properties()
    // {
    //     $this->expectException(MissingParameterException::class);

    //     $config = new Config();

    //     $config->testValues();

    //     return $config;
    // }

    /**
     * @test
     * @depends a_new_config_config_can_be_created_with_valid_arguements
     */
    public function the_merchantKey_can_be_updated($config)
    {
        $merchantKey = 'a-different-merchantKey';

        $config->setMerchantKey($merchantKey);

        $this->assertSame($config->getMerchantKey(), $merchantKey);
    }

    /**
     * @test
     * @depends a_new_config_config_can_be_created_with_valid_arguements
     */
    public function the_emailOrPhoneNumber_can_be_updated($config)
    {
        $emailOrPhoneNumber = '0987654321';

        $config->setEmailOrMobileNumber($emailOrPhoneNumber);

        $this->assertSame($config->getEmailOrMobileNumber(), $emailOrPhoneNumber);
    }

    /**
     * @test
     * @depends a_new_config_config_can_be_created_with_valid_arguements
     */
    public function the_package_version_can_be_updated($config)
    {
        $version = '7.0.0';

        $config->setPackageVersion($version);

        $this->assertSame($config->getPackageVersion(), $version);
    }
}
