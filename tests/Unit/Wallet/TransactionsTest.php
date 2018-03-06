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
use Qodehub\Bitgo\Exception\MissingParameterException;
use Qodehub\Bitgo\Utility\BitgoHandler;
use Qodehub\Bitgo\Wallet;
use Qodehub\Bitgo\Wallet\Transactions;

class TransactionsTest extends TestCase
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
    public function the_create_address_method_can_be_called_with_an_entry_static_coin_method()
    {
        /**
         * Set the currency name-space
         * @var Transactions
         */
        $instance = Bitgo::{$this->coin}()->wallet($this->walletId)->transactions();

        $this->assertInstanceOf(Transactions::class, $instance);
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
         * Call the Transactions Magic method on the wallet instance
         */
        $TransactionsInstance = $wallet->transactions();

        /**
         * Assert that the Transactions Instance received the wallet ID
         */
        $this->assertEquals($TransactionsInstance->getWalletId(), $this->walletId);

        return $TransactionsInstance;
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function the_instance_has_a_chain_method_for_setting_the_prevId($TransactionsInstance)
    {
        $TransactionsInstance->prevId('prev-id-1');

        $this->assertEquals($TransactionsInstance->getprevId(), 'prev-id-1');

        $TransactionsInstance->prevId('prev-id-2');

        $this->assertEquals($TransactionsInstance->getprevId(), 'prev-id-2');

        return $TransactionsInstance->prevId('prev-id-3');
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function the_instance_can_chain_to_an_allowMigrated_method_and_set_allTokens_property($TransactionsInstance)
    {
        $TransactionsInstance->allTokens(true);

        $this->assertEquals($TransactionsInstance->getallTokens(), true);

        $TransactionsInstance->allTokens(false);

        $this->assertEquals($TransactionsInstance->getallTokens(), false);

        return $TransactionsInstance->allTokens(true);
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function the_instance_should_be_able_to_find_a_single_record_with_its_id_in_a_chaind_find_method($TransactionsInstance)
    {
        $TransactionsInstance->find($this->transactionId);

        $this->assertEquals($TransactionsInstance->getTransactionId(), $this->transactionId);

        $TransactionsInstance->find('change-the-id');

        $this->assertEquals($TransactionsInstance->getTransactionId(), 'change-the-id');

        return $TransactionsInstance->find($this->transactionId);
    }

    /** @test */
    public function the_insance_can_be_accessed_statically_and_determine_the_coin_type_based_on_entry()
    {
        $instance = Transactions::{$this->coin}();

        $this->assertInstanceOf(Transactions::class, $instance);

        $this->assertEquals($instance->getCoinType(), $this->coin);
    }

    /** @test */
    public function a_call_to_the_run_method_should_return_an_error_if_the_walletID_is_missing()
    {
        /**
         * Mock the getClient method in the Transactions to intercept calls to the server
         */
        $mock = $this->getMockBuilder(Transactions::class)
            ->setMethods(['getClient'])
            ->getMock();

        $mock->method('getClient')->will($this->returnValue(null));

        $this->expectException(MissingParameterException::class);
        $mock->run();
    }

    /** @test */
    public function a_call_to_the_run_method_should_return_an_error_if_the_coin_value_is_missing()
    {
        /**
         * Mock the getClient method in the Transactions to intercept calls to the server
         */
        $mock = $this->getMockBuilder(Transactions::class)
            ->setMethods(['getClient'])
            ->getMock();

        $mock->method('getClient')->will($this->returnValue(new Client()));

        $this->expectException(MissingParameterException::class);
        $mock
            ->injectConfig($this->config)
            ->wallet($this->walletId)
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
         * Listen to the Transactions class method and use the interceptor
         *
         * Intercept all calls to the server from the createHandler method
         */
        $mock = $this->getMockBuilder(Transactions::class)
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
            "https://some-host.com/api/v2/" . $this->coin . "/wallet/" . $this->walletId . '/tx/',
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
         * Listen to the Transactions class method and use the interceptor
         *
         * Intercept all calls to the server from the createHandler method
         */
        $mock = $this->getMockBuilder(Transactions::class)
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
            ->find($this->transactionId)
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
            "https://some-host.com/api/v2/" . $this->coin . "/wallet/" . $this->walletId . "/tx/" . $this->transactionId,
            $request->getUri()->__toString()
        );
    }
}
