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
use Qodehub\Bitgo\Wallet\CreateAddress;

class CreateAddressTest extends TestCase
{
    protected $config;

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config();
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
        $createAddressInstance = $wallet->createAddress();

        /**
         * Assert that the CreateAddress Instance received the wallet ID
         */
        $this->assertEquals($createAddressInstance->getWalletId(), 'existing-wallet-id');

        return $createAddressInstance;
    }

    /**
     * @test
     * @depends the_instace_should_have_a_wallet_id_when_called_from_a_wallet_instance
     */
    public function the_instance_has_a_chain_method_for_setting_the_chain($createAddressInstance)
    {
        $createAddressInstance->chain(3);

        $this->assertEquals($createAddressInstance->getChain(), 3);

        return $createAddressInstance;
    }

    /** @test */
    public function a_call_to_the_run_method_should_return_an_error_if_the_walletID_is_missing()
    {
        /**
         * Mock the execute method in the CreateAddress to intercept calls to the server
         */
        $mock = $this->getMockBuilder(CreateAddress::class)
            ->setMethods(['execute'])
            ->getMock();

        $mock->method('execute')->will($this->returnValue(null));

        $this->expectException(MissingParameterException::class);
        $mock->chain(10)->run();
    }

    // /** @test */
    // public function a_call_to_the_run_method_should_return_an_error_if_the_chain_is_missing()
    // {
    //     /**
    //      * Mock the execute method in the CreateAddress to intercept calls to the server
    //      */
    //     $mock = $this->getMockBuilder(CreateAddress::class)
    //         ->setMethods(['execute'])
    //         ->getMock();

    //     $mock->method('execute')->will($this->returnValue(null));

    //     $this->expectException(\Qodehub\Bitgo\Exception\MissingParameterException::class);
    //     $mock->wallet('existing-wallet-id')->run();
    // }

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
         * Listen to the CreateAddress class method and use the interceptor
         *
         * Intercept all calls to the server from the createHandler method
         */
        $mock = $this->getMockBuilder(CreateAddress::class)
            ->setMethods(['createHandler'])
            ->getMock();

        $mock->expects($this->once())->method('createHandler')->will($this->returnValue($handlerStack));

        /**
         * Inject the configuration and use the
         */
        $mock
            ->injectConfig(new Config())

            //Setup the required parameters

            ->wallet('existing-wallet-id')
            ->chain(0);

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
        $this->assertEquals($request->getUri()->getHost(), 'www.bitgo.com', 'Hostname should be www.bitgo.com');
        $this->assertEquals($request->getHeaderLine('User-Agent'), Bitgo::CLIENT . ' v' . Bitgo::VERSION);

        $this->assertEquals($request->getUri()->getScheme(), 'https', 'it should be a https scheme');

        $this->assertContains(
            "https://www.bitgo.com/wallet/existing-wallet-id/address/0",
            $request->getUri()->__toString()
        );
    }
}
