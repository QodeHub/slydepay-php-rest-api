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

namespace Qodehub\Slydepay\Tests\Features\Api;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Qodehub\Slydepay\Api\Api;
use Qodehub\Slydepay\Config;
use Qodehub\Slydepay\Exception\UnauthorizedException;
use Qodehub\Slydepay\Slydepay;

class ApiTest extends TestCase
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
     * This is the emailOrPhoneNumber for the Slydepay Server
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
