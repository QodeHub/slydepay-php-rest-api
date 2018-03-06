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
use Qodehub\Bitgo\Utility\BitgoHandler;
use Qodehub\Bitgo\Wallet;
use Qodehub\Bitgo\Wallet\CreateAddress;
use Qodehub\Bitgo\Wallet\Transactions;

class TransactonsTest extends TestCase
{
    /**
     * The starting index number to list from. Default is 0.
     *
     * @var boolean
     */
    protected $skip;
    /**
     * Max number of results to return in a single call (default=25, max=250)
     *
     * @var number
     */
    protected $limit;
    /**
     * Omit inputs and outputs in the transaction results
     *
     * @var boolean
     */
    protected $compact;
    /**
     * A lower limit of blockchain height at which the transaction
     * was confirmed. Does not filter unconfirmed transactions.
     *
     * @var number
     */
    protected $minHeight;
    /**
     * An upper limit of blockchain height at which the transaction was confirmed.
     *
     * @var number
     */
    protected $maxHeight;
    /**
     * Only shows transactions with at least this many confirmations,
     * filters transactions that have fewer confirmations.
     *
     * @var number
     */
    protected $minConfirms;
    /**
     * This is the setup
     */

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
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->token, $this->secure, $this->host);
    }

    /** @test */
    public function the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance()
    {

        /**
         * Create the wallet instance
         * @var Wallet
         */
        $wallet = new Wallet('existing-wallet-id');

        /**
         * Call the createAddress Magic method on the wallet instance
         */
        $transactionsInstance = $wallet->transactions();

        /**
         * Assert that the CreateAddress Instance received the wallet ID
         */
        $this->assertEquals($transactionsInstance->getWalletId(), 'existing-wallet-id');

        return $transactionsInstance;
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function can_chain_and_assign_Skip_value($transactions)
    {

        $transactions->Skip(10);

        $this->assertEquals($transactions->getSkip(), 10);

        return $transactions;
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function can_chain_and_assign_Limit_value($transactions)
    {

        $transactions->Limit(9);

        $this->assertEquals($transactions->getLimit(), 9);

        return $transactions;
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function can_chain_and_assign_Compact_value($transactions)
    {

        $transactions->Compact(8);

        $this->assertEquals($transactions->getCompact(), 8);

        return $transactions;
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function can_chain_and_assign_MinHeight_value($transactions)
    {

        $transactions->MinHeight(7);

        $this->assertEquals($transactions->getMinHeight(), 7);

        return $transactions;
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function can_chain_and_assign_MaxHeight_value($transactions)
    {

        $transactions->MaxHeight(6);

        $this->assertEquals($transactions->getMaxHeight(), 6);

        return $transactions;
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function can_chain_and_assign_minConfirms_value($transactions)
    {

        $transactions->minConfirms(5);

        $this->assertEquals($transactions->getminConfirms(), 5);

        return $transactions;
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function can_chain_and_assign_InjectConfig_value($transactions)
    {

        $transactions->InjectConfig($this->config);

        $this->assertEquals($transactions->getConfig(), $this->config);

        return $transactions;
    }

    /** @test */
    public function test_that_a_call_to_the_server_all_transactions_will_be_successful_if_all_is_right()
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

            ->wallet('existing-wallet-id')
        ;

        /**
         * Run the call to the server
         */
        $result = $mock->get();

        /**
         * Run assertion that call reached the Mock Server
         */
        $this->assertEquals($result, ['X-Foo' => 'Bar']);

        /**
         * Grab the requests and test that the request parameters
         * are correct as expected.
         */
        $request = $container[0]['request'];

        $this->assertEquals($request->getMethod(), 'GET', 'it should be a get request.');
        $this->assertEquals($request->getUri()->getHost(), 'some-host.com', 'Hostname should be some-host.com');
        $this->assertEquals($request->getHeaderLine('User-Agent'), Bitgo::CLIENT . ' v' . Bitgo::VERSION);

        $this->assertEquals($request->getUri()->getScheme(), 'https', 'it should be a https scheme');

        $this->assertContains(
            "https://some-host.com/wallet/existing-wallet-id/tx/",
            $request->getUri()->__toString()
        );
    }
    /** @test */
    public function test_that_a_call_to_the_server_single_transactions_will_be_successful_if_all_is_right()
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

            ->wallet('existing-wallet-id')
        ;

        /**
         * Run the call to the server
         */
        $result = $mock->get('existing-transaction-id');

        /**
         * Run assertion that call reached the Mock Server
         */
        $this->assertEquals($result, ['X-Foo' => 'Bar']);

        /**
         * Grab the requests and test that the request parameters
         * are correct as expected.
         */
        $request = $container[0]['request'];

        $this->assertEquals($request->getMethod(), 'GET', 'it should be a get request.');
        $this->assertEquals($request->getUri()->getHost(), 'some-host.com', 'Hostname should be some-host.com');
        $this->assertEquals($request->getHeaderLine('User-Agent'), Bitgo::CLIENT . ' v' . Bitgo::VERSION);

        $this->assertEquals($request->getUri()->getScheme(), 'https', 'it should be a https scheme');

        $this->assertContains(
            "https://some-host.com/wallet/existing-wallet-id/tx/existing-transaction-id",
            $request->getUri()->__toString()
        );
    }
}
