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

namespace Qodehub\Bitgo\Tests\Unit\Api;

use PHPUnit\Framework\TestCase;
use Qodehub\Bitgo\Api\Api;
use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;
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
