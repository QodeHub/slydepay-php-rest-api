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

namespace Qodehub\Bitgo\Tests\Features\Wallet;

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
use Qodehub\Bitgo\Wallet\UpdateWallet;

class UpdateWalletTest extends TestCase
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
     * This is the coin type used for this test. Can be changed for other coin tests.
     * @var string
     */
    protected $coin = 'tbtc';

    /**
     * This is the label we will use for testing the wallet.
     * @var string
     */
    protected $label = 'my new wallet';

    /**
     * This is the ID of the wallet used in this test
     * @var string
     */
    protected $walletId = 'existing-wallet-id';

    /**
     * This is the waller passphrase that will be used in this test.
     * @var string
     */
    protected $walletPassphrase = 'hello-world';

    /**
     * Values of other optional parameters
     * used in this test.
     */
    protected $disableTransactionNotifications = true;
    protected $tokenFlushThresholds = 1000;
    protected $approvalsRequired = 10;

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function a_call_to_the_run_method_should_return_an_error_if_the_wallet_id_value_is_missing()
    {
        /**
         * Mock the getClient method in the UpdateWallet to intercept calls to the server
         */
        $mock = $this->getMockBuilder(UpdateWallet::class)
            ->setMethods(['getClient'])
            ->getMock();

        $mock->method('getClient')->will($this->returnValue(null));

        $this->expectException(MissingParameterException::class);

        $mock
            ->injectConfig($this->config)
            ->coinType($this->coin)
            ->setDisableTransactionNotifications($this->disableTransactionNotifications)
            ->setTokenFlushThresholds($this->tokenFlushThresholds)
            ->setApprovalsRequired($this->approvalsRequired)
            ->run();
    }

    /** @test */
    public function a_call_to_the_run_method_should_return_an_error_if_the_coin_value_is_missing()
    {
        /**
         * Mock the getClient method in the UpdateWallet to intercept calls to the server
         */
        $mock = $this->getMockBuilder(UpdateWallet::class)
            ->setMethods(['getClient'])
            ->getMock();

        $mock->method('getClient')->will($this->returnValue(new Client()));

        $this->expectException(MissingParameterException::class);

        $mock
            ->injectConfig($this->config)
            ->label($this->label)
            ->setDisableTransactionNotifications($this->disableTransactionNotifications)
            ->setTokenFlushThresholds($this->tokenFlushThresholds)
            ->setApprovalsRequired($this->approvalsRequired)
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
         * Listen to the UpdateWallet class method and use the interceptor
         *
         * Intercept all calls to the server from the createHandler method
         */
        $mock = $this->getMockBuilder(UpdateWallet::class)
            ->setMethods(['createHandler'])
            ->getMock();

        $mock->expects($this->once())->method('createHandler')->will($this->returnValue($handlerStack));

        /**
         * Inject the configuration and use the
         */
        $mock
            ->injectConfig($this->config)

            //Setup the required parameters

            ->coinType($this->coin)
            ->wallet($this->walletId)
            ->label($this->label)
            ->setDisableTransactionNotifications($this->disableTransactionNotifications)
            ->setTokenFlushThresholds($this->tokenFlushThresholds)
            ->setApprovalsRequired($this->approvalsRequired)
        ;

        /**
         * Run the call to the server
         */
        $result = $mock->run();

        /**
         * Run assertion that call reached the Mock Server
         */
        $this->assertEquals($result, json_decode(json_encode(['X-Foo' => 'Bar'])));

        /**
         * Grab the requests and test that the request parameters
         * are correct as expected.
         */
        $request = $container[0]['request'];

        $this->assertEquals($request->getMethod(), 'PUT', 'it should be a post request.');
        $this->assertEquals($request->getUri()->getHost(), 'some-host.com', 'Hostname should be some-host.com');
        $this->assertEquals($request->getHeaderLine('User-Agent'), Bitgo::CLIENT . ' v' . Bitgo::VERSION);

        $this->assertEquals($request->getUri()->getScheme(), 'https', 'it should be a https scheme');

        $this->assertContains(
            "https://some-host.com/api/v2/" . $this->coin . "/wallet/" . $this->walletId,
            $request->getUri()->__toString()
        );
    }
}
