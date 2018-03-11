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

use GuzzleHttp\Exception\TransferException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\Utility\BitgoHandler;

class BitgoHandlerTest extends TestCase
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

    public function test_createHandler()
    {
        $mock = $this->getMockBuilder(BitgoHandler::class)
            ->setConstructorArgs([$this->config])
            ->setMethods(['pushHeaderMiddleware', 'pushRetryMiddleware', 'pushBasicAuthMiddleware'])
            ->getMockForAbstractClass();

        $requestMock = $this->createMock(RequestInterface::class, ['withHeader']);
        $responseMock = $this->createMock(ResponseInterface::class);
        $tfException = $this->createMock(TransferException::class);

        $requestMock->expects($this->exactly(2))->method('withHeader');

        $mock->expects($this->once())->method('pushHeaderMiddleware')->with(
            $this->callback(function (callable $callable) use ($requestMock) {
                $callable($requestMock);

                return true;
            })
        );

        $mock->expects($this->Once())->method('pushBasicAuthMiddleware')->with(
            $this->callback(function (callable $callable) use ($requestMock) {
                $callable($requestMock);

                return true;
            })
        );

        $mock->expects($this->once())->method('pushRetryMiddleware')->with(
            $this->callback(function (callable $callable) use ($requestMock, $responseMock, $tfException) {
                $callable(10, $requestMock, $responseMock, $tfException);
                return $callable;
            }),
            $this->callback(function (callable $callable) {
                $result = $callable(10);
                $this->assertTrue(is_int($result), 'Expects the decider function to return a number in mili-seconds');

                return true;
            })
        );

        $response = $mock->createHandler();
    }
}
