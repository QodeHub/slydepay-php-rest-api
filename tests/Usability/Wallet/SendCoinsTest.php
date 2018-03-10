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

namespace Qodehub\Bitgo\Tests\Usability\Wallet;

use GuzzleHttp\Client;
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
use Qodehub\Bitgo\Wallet\SendCoins;

class SendCoinsTest extends TestCase
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
     * This will be a receiving BTC address
     * @var string
     */
    protected $address = 'some-receiving-btc-address';

    /**
     * This will be the amount of coins we will use for this test.
     * @var integer
     */
    protected $amount = 100;

    /**
     * This is the waller passphrase that will be used in this test.
     * @var string
     */
    protected $walletPassphrase = 'hello-world';

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function the_insance_can_be_accessed_statically_and_determine_the_coin_type_based_on_entry()
    {
        $instance = SendCoins::{$this->coin}();

        $this->assertInstanceOf(SendCoins::class, $instance);

        $this->assertEquals($instance->getCoinType(), $this->coin);
    }

    /** @test */
    public function a_call_to_the_run_method_should_return_an_error_if_the_walletID_is_missing()
    {
        /**
         * Mock the getClient method in the SendCoins to intercept calls to the server
         */
        $mock = $this->getMockBuilder(SendCoins::class)
            ->setMethods(['getClient'])
            ->getMock();

        $mock->method('getClient')->will($this->returnValue(null));

        $this->expectException(MissingParameterException::class);

        $mock
            ->injectConfig($this->config)
            ->coinType($this->coin)
            ->to($this->amount)
            ->address($this->address)
            ->amount($this->amount)
            ->passphrase($this->walletPassphrase)
            ->run();
    }

    /** @test */
    public function a_call_to_the_run_method_should_return_an_error_if_the_receiving_address_is_missing()
    {
        /**
         * Mock the getClient method in the SendCoins to intercept calls to the server
         */
        $mock = $this->getMockBuilder(SendCoins::class)
            ->setMethods(['getClient'])
            ->getMock();

        $mock->method('getClient')->will($this->returnValue(null));

        $this->expectException(MissingParameterException::class);

        $mock
            ->injectConfig($this->config)
            ->wallet($this->walletId)
            ->coinType($this->coin)
            ->amount($this->amount)
            ->passphrase($this->walletPassphrase)
            ->run();
    }

    /** @test */
    public function a_call_to_the_run_method_should_return_an_error_if_the_wallet_passphrase_is_missing()
    {
        /**
         * Mock the getClient method in the SendCoins to intercept calls to the server
         */
        $mock = $this->getMockBuilder(SendCoins::class)
            ->setMethods(['getClient'])
            ->getMock();

        $mock->method('getClient')->will($this->returnValue(null));

        $this->expectException(MissingParameterException::class);

        $mock
            ->wallet($this->walletId)
            ->coinType($this->coin)
            ->to($this->amount)
            ->address($this->address)
            ->amount($this->amount)
            ->run();
    }

    /** @test */
    public function a_call_to_the_run_method_should_return_an_error_if_the_wallet_amount_is_missing()
    {
        /**
         * Mock the getClient method in the SendCoins to intercept calls to the server
         */
        $mock = $this->getMockBuilder(SendCoins::class)
            ->setMethods(['getClient'])
            ->getMock();

        $mock->method('getClient')->will($this->returnValue(null));

        $this->expectException(MissingParameterException::class);

        $mock
            ->injectConfig($this->config)
            ->wallet($this->walletId)
            ->coinType($this->coin)
            ->to($this->amount)
            ->address($this->address)
            ->passphrase($this->walletPassphrase)
            ->run();
    }

    /** @test */
    public function a_call_to_the_run_method_should_return_an_error_if_the_coin_type_value_is_missing()
    {
        /**
         * Mock the getClient method in the SendCoins to intercept calls to the server
         */
        $mock = $this->getMockBuilder(SendCoins::class)
            ->setMethods(['getClient'])
            ->getMock();

        $mock->method('getClient')->will($this->returnValue(new Client()));

        $this->expectException(MissingParameterException::class);

        $mock
            ->injectConfig($this->config)
            ->wallet($this->walletId)
            ->to($this->amount)
            ->address($this->address)
            ->amount($this->amount)
            ->passphrase($this->walletPassphrase)
            ->run();
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
         * Listen to the SendCoins class method and use the interceptor
         *
         * Intercept all calls to the server from the createHandler method
         */
        $mock = $this->getMockBuilder(SendCoins::class)
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
            ->to($this->amount)
            ->address($this->address)
            ->amount($this->amount)
            ->passphrase($this->walletPassphrase)

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

        $this->assertEquals($request->getMethod(), 'POST', 'it should be a post request.');
        $this->assertEquals($request->getUri()->getHost(), $this->host, 'Hostname should be' . $this->host);
        $this->assertEquals($request->getHeaderLine('User-Agent'), Bitgo::CLIENT . ' v' . Bitgo::VERSION);

        $this->assertEquals($request->getUri()->getScheme(), 'https', 'it should be a https scheme');

        $this->assertContains(
            "https://some-host.com/api/v2/" . $this->coin . "/wallet/" . $this->walletId . '/sendcoins',
            $request->getUri()->__toString()
        );
    }
}
