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

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\Exception\MissingParameterException;
use Qodehub\Bitgo\Utility\BitgoHandler;
use Qodehub\Bitgo\Wallet;
use Qodehub\Bitgo\Wallet\Addresses;

class AddressesTest extends TestCase
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
     * This is the ID of the address used in this test
     * @var string
     */
    protected $addressId = 'existing-address';

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function the_create_address_method_can_be_called_with_an_entry_static_coin_method()
    {
        /**
         * Set the currency name-space
         * @var Addresses
         */
        $instance = Bitgo::tbtc()->wallet($this->walletId)->addresses();

        $this->assertInstanceOf(Addresses::class, $instance);
    }

    /** @test */
    public function the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance()
    {

        /**
         * Create the wallet instance
         * @var Wallet
         */
        $wallet = new Wallet($this->walletId);

        /**
         * Call the createAddress Magic method on the wallet instance
         */
        $createAddressInstance = $wallet->createAddress();

        /**
         * Assert that the Addresses Instance received the wallet ID
         */
        $this->assertEquals($createAddressInstance->getWalletId(), $this->walletId);

        return $createAddressInstance;
    }

    /** @test */
    public function a_call_to_the_run_method_should_return_an_error_if_the_walletID_is_missing()
    {
        /**
         * Mock the execute method in the Addresses to intercept calls to the server
         */
        $mock = $this->getMockBuilder(Addresses::class)
            ->setMethods(['execute'])
            ->getMock();

        $mock->method('execute')->will($this->returnValue(null));

        $this->expectException(MissingParameterException::class);
        $mock->run();
    }

    /** @test */
    public function a_call_to_the_run_method_should_return_an_error_if_the_coinType_is_missing()
    {
        /**
         * Mock the execute method in the Addresses to intercept calls to the server
         */
        $mock = $this->getMockBuilder(Addresses::class)
            ->setMethods(['execute'])
            ->getMock();

        $mock->method('execute')->will($this->returnValue(null));

        $this->expectException(MissingParameterException::class);
        $mock->run();
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
         * Listen to the Addresses class method and use the interceptor
         *
         * Intercept all calls to the server from the createHandler method
         */
        $mock = $this->getMockBuilder(Addresses::class)
            ->setMethods(['createHandler'])
            ->getMock();

        $mock->expects($this->once())->method('createHandler')->will($this->returnValue($handlerStack));

        /**
         * Inject the configuration and use the
         */
        $mock
            ->injectConfig($this->config)

            ->coinType('tbtc')

            //Setup the required parameters

            ->wallet($this->walletId);

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
        $this->assertEquals($request->getUri()->getHost(), 'some-host.com', 'Hostname should be some-host.com');
        $this->assertEquals($request->getHeaderLine('User-Agent'), Bitgo::CLIENT . ' v' . Bitgo::VERSION);

        $this->assertEquals($request->getUri()->getScheme(), 'https', 'it should be a https scheme');

        $this->assertContains(
            "https://some-host.com/api/v2/tbtc/wallet/existing-wallet-id/addresses",
            $request->getUri()->__toString()
        );
    }

    /** @test */
    public function test_that_a_call_to_the_server_will_be_successful_if_all_is_right_for_single_address()
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
         * Listen to the Addresses class method and use the interceptor
         *
         * Intercept all calls to the server from the createHandler method
         */
        $mock = $this->getMockBuilder(Addresses::class)
            ->setMethods(['createHandler'])
            ->getMock();

        $mock->expects($this->once())->method('createHandler')->will($this->returnValue($handlerStack));

        /**
         * Inject the configuration and use the
         */
        $mock
            ->injectConfig($this->config)

            ->coinType('tbtc')

            //Setup the required parameters

            ->wallet($this->walletId)

            ->address($this->addressId);

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
        $this->assertEquals($request->getUri()->getHost(), 'some-host.com', 'Hostname should be some-host.com');
        $this->assertEquals($request->getHeaderLine('User-Agent'), Bitgo::CLIENT . ' v' . Bitgo::VERSION);

        $this->assertEquals($request->getUri()->getScheme(), 'https', 'it should be a https scheme');

        $this->assertContains(
            "https://some-host.com/api/v2/tbtc/wallet/existing-wallet-id/address/existing-address",
            $request->getUri()->__toString()
        );
    }
}
