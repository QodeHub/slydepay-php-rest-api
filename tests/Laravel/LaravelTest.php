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

    protected function getPackageProviders($app)
    {
        return [PackageServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'laravel-hubtel-payment' => Bitgo::class,
        ];
    }

    public function test_getCongig_returns_valid_config()
    {
        $this->assertInstanceOf(Config::class, Bitgo::btc()->getConfig());
    }

    // public function test_receivemoney_returns_valid_receivemoney_class()
    // {
    //     $this->assertInstanceOf(ReceiveMoney::class, HubtelPayment::ReceiveMoney());
    // }

    // public function test_sendmoney_returns_valid_sendmoney_class()
    // {
    //     $this->assertInstanceOf(SendMoney::class, HubtelPayment::SendMoney());
    // }

    // public function test_refund_returns_valid_refund_class()
    // {
    //     $this->assertInstanceOf(Refund::class, HubtelPayment::Refund());
    // }

    public function test_env_configuration()
    {
        putenv("BITGO_HOST=testhost.run");
        putenv("BITGO_TOKEN=testtoken");
        putenv("BITGO_SECURE=true");
        putenv("BITGO_PORT=1234");

        $configInstance = Bitgo::getConfig();

        $this->assertSame($configInstance->getToken(), 'testtoken');
        $this->assertSame($configInstance->getHost(), 'testhost.run');
        $this->assertSame($configInstance->isSecure(), true);
        $this->assertSame($configInstance->getPort(), 1234);
    }
}
