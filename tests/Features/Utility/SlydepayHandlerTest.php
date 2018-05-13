<?php
/**
 * @package     Qodehub\Slydepay
 * @link        https://github.com/qodehub/slydepay-php
 *
 * @author      Ariama O. Victor (ovac4u) <victorariama@qodehub.com>
 * @link        http://www.ovac4u.com
 *
 * @license     https://github.com/qodehub/slydepay-php/blob/master/LICENSE
 * @copyright   (c) 2018, QodeHub, Ltd
 */

namespace Qodehub\Slydepay\Tests\Features\Wallet;

use GuzzleHttp\Exception\TransferException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Qodehub\Slydepay\Config;
use Qodehub\Slydepay\Utility\SlydepayHandler;

class SlydepayHandlerTest extends TestCase
{

    /**
     * The configuration instance.
     * @var Config
     */
    protected $config;

    /**
     * This Package Version.
     *
     * @var string
     */
    protected $version = '1.0.0';
    /**
     * This will be the Authorization merchantKey
     *
     * @var string
     */
    protected $merchantKey = 'some-valid-merchantKey';
    /**
     * This is the emailOrPhoneNumber for the Bitgo Server
     *
     * @var string
     */
    protected $emailOrPhoneNumber = 1234567890;

    /**
     * Setup the test environment viriables
     * @return [type] [description]
     */
    public function setup()
    {
        $this->config = new Config($this->emailOrPhoneNumber, $this->merchantKey);
    }

    public function test_createHandler()
    {
        $mock = $this->getMockBuilder(SlydepayHandler::class)
            ->setConstructorArgs([$this->config])
            ->setMethods(['pushHeaderMiddleware', 'pushRetryMiddleware', 'pushBasicAuthMiddleware'])
            ->getMockForAbstractClass();

        $requestMock = $this->createMock(RequestInterface::class, ['withHeader']);
        $responseMock = $this->createMock(ResponseInterface::class);
        $tfException = $this->createMock(TransferException::class);

        $requestMock->expects($this->exactly(1))->method('withHeader');

        $mock->expects($this->once())->method('pushHeaderMiddleware')->with(
            $this->callback(function (callable $callable) use ($requestMock) {
                $callable($requestMock);

                return true;
            })
        );

        // $mock->expects($this->Once())->method('pushBasicAuthMiddleware')->with(
        //     $this->callback(function (callable $callable) use ($requestMock) {
        //         $callable($requestMock);

        //         return true;
        //     })
        // );

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
