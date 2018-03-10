<?php

/**
 * @package     Qodehub\Bitgo
 * @link        https://github.com/qodehub/bitgo-php
 *
 * @author      Ariama O. Victor (ovac4u) <victorariama@qodehub.com>
 * @link        http://www.ovac4u.com
 *
 * @license     https://github.com/qodehub/bitgo-php/blob/master/LICENSE
 * @copyright   (c) 2018, QodeHub, Ltd
 */

namespace Qodehub\Bitgo\Tests\Unit;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Qodehub\Bitgo\Api\Api;
use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\Wallet;
use Qodehub\Bitgo\Wallet\CreateWallet;

class Test extends TestCase
{

    /**
     * The bearer token that will be used by this API
     * @var string
     */
    protected $token = 'existing-token';

    /**
     * This will determine if HTTP(S) will be used
     * @var boolean
     */
    protected $secure = true;

    /**
     * This is the host on which the Bitgo API is running.
     * @var string
     */
    protected $host = 'some-host.com';

    /**
     * The configuration instance.
     * @var Config
     */
    protected $config;

    /**
     * This is the ID of the wallet used in this test
     * @var string
     */
    protected $walletId = 'existing-wallet-id';

    /**
     * This is the coin type used for this test. Can be changed for other coin tests.
     * @var string
     */
    protected $coin = 'tbtc';

    /**
     * This is the port used in this configuration.
     * @var string
     */
    protected $port = 3080;

    /**
     * Tis the transactionID used in this test.
     * @var string
     */
    protected $transactionId = 'existing-transaction-id';

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function the_package_version_is_v2()
    {
        $instance = new Bitgo();

        $this->assertSame($instance->getPackageVersion(), '2.0.0');
    }

    /** @test */
    public function the_configuration_can_be_passed_into_the_constructor()
    {
        $instance = new Bitgo($this->config);

        $this->assertEquals($instance->getConfig(), $this->config);
    }

    /** @test */
    public function a_valid_configuraiton_data_array_can_be_passed_into_the_constructor()
    {
        $config = [
            'token' => $this->token,
            'secure' => $this->secure,
            'host' => $this->host,
            'port' => null,
        ];

        $instance = new Bitgo($config);

        $this->assertEquals($this->config, $instance->getConfig());
    }

    /** @test */
    public function an_instance_can_be_created_using_the_make_static_method()
    {
        $instance = Bitgo::make();

        $this->assertInstanceOf(Bitgo::class, $instance);
    }

    /** @test */
    public function a_new_instance_can_recive_the_configuration_parameters_as_arguements()
    {
        $instance = new Bitgo($this->token, $this->secure, $this->host, $this->port);

        $this->assertSame($instance->getConfig()->getToken(), $this->token);
        $this->assertSame($instance->getConfig()->isSecure(), $this->secure);
        $this->assertSame($instance->getConfig()->getHost(), $this->host);
        $this->assertSame($instance->getConfig()->getPort(), $this->port);
    }

    /** @test */
    public function a_new_instance_can_be_created_using_the_static_coin_method_and_hold_the_wallet_coin_type()
    {
        $instance = Bitgo::{$this->coin}();

        $this->assertInstanceOf(Bitgo::class, $instance);
        $this->assertSame($this->coin, $instance->getCoinType());
    }

    /** @test */
    public function a_new_bitgo_instance_can_recieve_config_as_arguement_to_the_static_coin_name_method()
    {
        $instance = Bitgo::{$this->coin}($this->config);

        $this->assertInstanceOf(Bitgo::class, $instance);
        $this->assertSame($this->coin, $instance->getCoinType());

        $this->assertInstanceOf(Config::class, $instance->getConfig());
        $this->assertEquals($this->config, $instance->getConfig());
    }

    /** @test */
    public function the_version_on_the_configuration_instance_can_be_updated_from_the_bitgo_instance()
    {
        $instance = new Bitgo();

        $this->assertSame('2.0.0', $instance->getPackageVersion());

        /**
         * Change the version and see that it is the same.
         * @var string
         */
        $instance->setPackageVersion($newVersion = '3.0.0');

        $this->assertSame($newVersion, $instance->getPackageVersion());
    }

    /** @test */
    public function a_static_call_to_wallet_returns_a_wallet_instance()
    {
        $instance = Bitgo::wallet();

        $this->assertInstanceOf(Wallet::class, $instance);
    }

    /** @test */
    public function a_static_call_to_createWallet_returns_a_create_wallet_instance()
    {
        $instance = Bitgo::createWallet();

        $this->assertInstanceOf(CreateWallet::class, $instance);
    }

    /** @test */
    public function expect_an_exception_for_static_call_to_a_classname_outside_the_scope()
    {
        $this->expectException(\Error::class);

        Bitgo::coin();
    }

    /** @test */
    public function the_coin_type_can_be_set_on_a_bitgo_instance()
    {
        $instance = new Bitgo();

        $instance->coinType($this->coin);

        $this->assertSame($this->coin, $instance->getCoinType());
    }

    /** @test */
    public function bad_method_calls_should_throw_a_badMethodCallException_error()
    {
        $instance = new Bitgo();

        $this->expectException(\BadMethodCallException::class);

        $instance->someRandomBadMethod();
    }
}
