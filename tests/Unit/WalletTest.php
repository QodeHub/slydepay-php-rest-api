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

namespace Qodehub\Bitgo\Tests\Unit\WalletTest;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\Utility\BitgoHandler;
use Qodehub\Bitgo\Wallet;
use Qodehub\Bitgo\Wallet\Addresses;
use Qodehub\Bitgo\Wallet\CreateAddress;
use Qodehub\Bitgo\Wallet\CreateWallet;
use Qodehub\Bitgo\Wallet\SendCoins;

class WalletTest extends TestCase
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
    public function the_addresses_method_should_give_an_addresses_instance()
    {
        $this->assertInstanceOf(Addresses::class, Wallet::{$this->coin}()->addresses());
    }

    /** @test */
    public function the_create_address_method_should_give_a_create_address_instance()
    {
        $this->assertInstanceOf(CreateAddress::class, Wallet::{$this->coin}()->createAddress());
    }

    /** @test */
    public function the_send_coins_method_should_give_a_send_class_instance()
    {
        $this->assertInstanceOf(SendCoins::class, Wallet::{$this->coin}()->SendCoins());
    }

    /** @test */
    public function the_create_wallet_method_returns_a_create_wallet_instance()
    {
        $this->assertInstanceOf(CreateWallet::class, Wallet::{$this->coin}()->CreateWallet());
    }

    /** @test */
    public function the_transactions_method_returns_a_transaction_instance()
    {
        $this->assertInstanceOf(CreateWallet::class, Wallet::{$this->coin}()->CreateWallet());
    }

    /** @test */
    public function test_that_a_call_to_the_server_will_be_successful_if_all_is_right()
    {
        /**
         * Setup the Handler and middlewares interceptor to intercept the call to the server
         */
        $container = [];

        $history = Middleware::history($container);

        $httpMock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['X-Foo' => 'Bar'])),
        ]);

        $handlerStack = (new BitgoHandler($this->config, HandlerStack::create($httpMock)))->createHandler();

        $handlerStack->push($history);

        /**
         * Listen to the Wallet class method and use the interceptor
         *
         * Intercept all calls to the server from the createHandler method
         */
        $mock = $this->getMockBuilder(Wallet::class)
            ->setMethods(['createHandler'])
            ->getMock();

        $mock->expects($this->once())->method('createHandler')->will($this->returnValue($handlerStack));

        /**
         * Inject the configuration and use the
         */
        $mock
            ->injectConfig($this->config)

            //Setup the required parameters

            ->wallet($this->walletId)
            ->coinType($this->coin)
        ;

        /**
         * Run the call to the server
         */
        $result = $mock->run();

        /**
         * Run assertion that call reached the Mock Server
         */
        $this->assertEquals($result, ['X-Foo' => 'Bar']);

        /**
         * Grab the requests and test that the request parameters
         * are correct as expected.
         */
        $request = $container[0]['request'];

        $this->assertEquals($request->getMethod(), 'GET', 'it should be a post request.');
        $this->assertEquals($request->getUri()->getHost(), $this->host, 'Hostname should be' . $this->host);
        $this->assertEquals($request->getHeaderLine('User-Agent'), Bitgo::CLIENT . ' v' . Bitgo::VERSION);

        $this->assertEquals($request->getUri()->getScheme(), 'https', 'it should be a https scheme');

        $this->assertContains(
            "https://some-host.com/api/v2/" . $this->coin . "/wallet/",
            $request->getUri()->__toString()
        );
    }

    /** @test */
    public function test_that_a_call_to_the_server_will_be_successful_if_all_is_right_for_a_single_transaction()
    {
        /**
         * Setup the Handler and middlewares interceptor to intercept the call to the server
         */
        $container = [];

        $history = Middleware::history($container);

        $httpMock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode(['X-Foo' => 'Bar'])),
        ]);

        $handlerStack = (new BitgoHandler($this->config, HandlerStack::create($httpMock)))->createHandler();

        $handlerStack->push($history);

        /**
         * Listen to the Wallet class method and use the interceptor
         *
         * Intercept all calls to the server from the createHandler method
         */
        $mock = $this->getMockBuilder(Wallet::class)
            ->setMethods(['createHandler'])
            ->getMock();

        $mock->expects($this->once())->method('createHandler')->will($this->returnValue($handlerStack));

        /**
         * Inject the configuration and use the
         */
        $mock
            ->injectConfig($this->config)

            //Setup the required parameters

            ->wallet($this->walletId)
            ->coinType($this->coin)
            // ->find($this->walletId)
        ;

        /**
         * Run the call to the server
         */
        $result = $mock->run();

        /**
         * Run assertion that call reached the Mock Server
         */
        $this->assertEquals($result, ['X-Foo' => 'Bar']);

        /**
         * Grab the requests and test that the request parameters
         * are correct as expected.
         */
        $request = $container[0]['request'];

        $this->assertEquals($request->getMethod(), 'GET', 'it should be a post request.');
        $this->assertEquals($request->getUri()->getHost(), $this->host, 'Hostname should be' . $this->host);
        $this->assertEquals($request->getHeaderLine('User-Agent'), Bitgo::CLIENT . ' v' . Bitgo::VERSION);

        $this->assertEquals($request->getUri()->getScheme(), 'https', 'it should be a https scheme');

        $this->assertContains(
            "https://some-host.com/api/v2/" . $this->coin . "/wallet/" . $this->walletId,
            $request->getUri()->__toString()
        );
    }
}
