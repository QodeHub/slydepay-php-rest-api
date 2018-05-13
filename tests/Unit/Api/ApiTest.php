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

namespace Qodehub\Slydepay\Tests\Unit\Api;

use PHPUnit\Framework\TestCase;
use Qodehub\Slydepay\Api\Api;
use Qodehub\Slydepay\Bitgo;
use Qodehub\Slydepay\Config;

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

    public function test_api_constructor_must_receive_config_type_constructor()
    {
        $this->expectException('TypeError');

        $mock = $this->getMockBuilder(Api::class)
            ->setConstructorArgs([1])
            ->getMockForAbstractClass();
    }

    public function test_api_constructor_must_take_in_arguement()
    {
        $this->expectException('ArgumentCountError');

        $mock = $this->getMockForAbstractClass(Api::class);
    }

    public function test_api_constructor_accepts_config_in_constructor()
    {
        $mock = $this->getMockBuilder(Api::class)
            ->setConstructorArgs([$this->config])
            ->getMockForAbstractClass();

        $this->assertAttributeEquals($this->config, 'config', $mock);
        $this->assertInstanceOf(Api::class, $mock->injectConfig($this->config), 'it should return Api::class instance');
    }

    public function test_api_set_and_get_base_path()
    {
        $mock = $this->getMockBuilder(Api::class)
            ->setConstructorArgs([$this->config])
            ->getMockForAbstractClass();

        $mock->setBasePath('/somebasepath');

        $this->assertEquals($mock->getBasePath(), '/somebasepath', 'it should update the base path');
    }

    public function test_api_http_methods()
    {
        $path = '/some_path';
        $parameters = ['hello' => 'world'];

        $mock = $this->getMockBuilder(Api::class)
            ->disableOriginalConstructor()
            ->setMethods(['execute'])
            ->getMockForAbstractClass();

        $mock->expects($this->exactly(7))
            ->method('execute')
            ->withConsecutive(
                [$this->equalTo('get'), $this->equalTo($path), $this->equalTo($parameters)],
                [$this->equalTo('post'), $this->equalTo($path), $this->equalTo($parameters)],
                [$this->equalTo('put'), $this->equalTo($path), $this->equalTo($parameters)],
                [$this->equalTo('delete'), $this->equalTo($path), $this->equalTo($parameters)],
                [$this->equalTo('patch'), $this->equalTo($path), $this->equalTo($parameters)],
                [$this->equalTo('head'), $this->equalTo($path), $this->equalTo($parameters)],
                [$this->equalTo('options'), $this->equalTo($path), $this->equalTo($parameters)]
            );

        $mock->_get($path, $parameters);
        $mock->_post($path, $parameters);
        $mock->_put($path, $parameters);
        $mock->_delete($path, $parameters);
        $mock->_patch($path, $parameters);
        $mock->_head($path, $parameters);
        $mock->_options($path, $parameters);
    }

    public function test_inject_config()
    {
        $mock = $this->getMockBuilder(Api::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $mock->injectConfig($this->config);

        $this->assertSame($this->config, $mock->getConfig(), 'it should inject the configuration on the api');
    }

    public function test_get_function()
    {
        $mock = $this->getMockBuilder(Api::class)
            ->disableOriginalConstructor()
            ->setMethods(['run'])
            ->getMockForAbstractClass();

        $mock->expects($this->exactly(1))
            ->method('run');

        $mock->get();
    }
}
