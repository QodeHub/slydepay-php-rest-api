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

namespace Qodehub\Bitgo\Tests\Features\Api;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Qodehub\Bitgo\Api\Api;
use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\Exception\UnauthorizedException;
use Qodehub\Bitgo\Wallet;

class ApiTest extends TestCase
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

    public function test_api_execute_methods_requires_config()
    {
        $this->expectException('RuntimeException');

        $path = '/some_path';
        $parameters = ['hello' => 'world'];

        $mock = $this->getMockBuilder(Api::class)
            ->disableOriginalConstructor()
            ->setMethods(['getClient'])
            ->getMockForAbstractClass();

        $mock->_get($path, $parameters);
    }

    public function test_api_execute_throws_ClientException_if_server_gives_error()
    {
        $this->expectException(UnauthorizedException::class);

        $httpMock = new MockHandler([
            new Response(401, ['X-Foo' => 'Bar']),
        ]);

        $handler = HandlerStack::create($httpMock);

        $path = '/some_path';
        $parameters = ['hello' => 'world'];

        $mock = $this->getMockBuilder(Api::class)
            ->setConstructorArgs([$this->config])
            ->setMethods(['createHandler'])
            ->getMockForAbstractClass();

        $mock->expects($this->once())
            ->method('createHandler')
            ->will($this->returnValue($handler));

        $mock->_get($path, $parameters);
    }

    public function test_api_execute_test_successful_call()
    {
        $path = '/some_path';
        $parameters = ['hello' => 'world'];

        $httpMock = new MockHandler([
            new Response(200, ['X-Foo' => 'Bar'], json_encode($parameters)),
        ]);

        $handler = HandlerStack::create($httpMock);

        $mock = $this->getMockBuilder(Api::class)
            ->setConstructorArgs([$this->config])
            ->setMethods(['createHandler'])
            ->getMockForAbstractClass();

        $mock->expects($this->once())
            ->method('createHandler')
            ->will($this->returnValue($handler));

        $response = $mock->_get($path, $parameters);

        $this->assertSame(json_encode($response), json_encode($parameters));
    }

    public static function callProtectedMethod($object, $method, array $args = array())
    {
        $class = new \ReflectionClass(get_class($object));
        $method = $class->getMethod($method);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }

    public function test_api_createHandler_method()
    {

        $mock = $this->getMockBuilder(Api::class)
            ->setConstructorArgs([$this->config])
            ->getMockForAbstractClass();

        $handlerStack = self::callProtectedMethod($mock, 'createHandler', [$this->config]);

        self::assertInstanceOf(HandlerStack::class, $handlerStack);
    }

    public function test_inject_config()
    {
        $mock = $this->getMockBuilder(Api::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $mock->injectConfig($this->config);

        $this->assertSame($this->config, $mock->getConfig(), 'it should inject the configuration on the api');
    }
}
