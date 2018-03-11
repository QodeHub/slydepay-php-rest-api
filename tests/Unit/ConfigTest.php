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

namespace Qodehub\Bitgo\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;

class ConfigTest extends TestCase
{
    /**
     * This Package Version.
     *
     * @var string
     */
    protected $version = '2.0.0';
    /**
     * This will be the Authorization Token
     *
     * @var string
     */
    protected $token = 'some-valid-token';
    /**
     * This is the host for the Bitgo Server
     *
     * @var string
     */
    protected $host = 'test.bitgo.com';
    /**
     * This will be the port on which the server is running.
     *
     * @var integer
     */
    protected $port = 443;
    /**
     * This will be a boolean as to if or not the server
     * runs on https.
     *
     * @var boolean
     */
    protected $secure = true;
    /**
     * This is the scheme. Eg: https, http, ftp, etc..
     * This will be set automatically depending on
     * if the secure flag is true or false
     *
     * @var string
     */
    protected $scheme = 'https';
    /**
     * This is a base URL used in place of the URL.
     *
     * @var string
     */
    protected $baseUrl = 'https://test.bitgo.com';

    /** @test */
    public function a_new_config_config_can_be_created_with_valid_arguements()
    {
        $config = new Config($this->token, $this->secure, $this->host, $this->port);

        $this->assertSame($config->getToken(), $this->token);
        $this->assertSame($config->isSecure(), $this->secure);
        $this->assertSame($config->getHost(), $this->host);
        $this->assertSame($config->getPort(), $this->port);

        return $config;
    }

    /**
     * @test
     * @depends a_new_config_config_can_be_created_with_valid_arguements
     */
    public function the_base_url_can_be_updated_in_the_configuration($config)
    {
        $baseUrl = 'https://newbase.bitgo.com';

        $config->setBaseUrl($baseUrl);

        $this->assertSame($config->getBaseUrl(), $baseUrl);
    }

    /**
     * @test
     * @depends a_new_config_config_can_be_created_with_valid_arguements
     */
    public function the_token_can_be_updated($config)
    {
        $token = 'a-different-token';

        $config->setToken($token);

        $this->assertSame($config->getToken(), $token);
    }

    /**
     * @test
     * @depends a_new_config_config_can_be_created_with_valid_arguements
     */
    public function the_secure_flag_can_be_updated($config)
    {
        $config->setSecure(false);

        $this->assertFalse($config->isSecure());
    }

    /**
     * @test
     * @depends a_new_config_config_can_be_created_with_valid_arguements
     */
    public function the_host_can_be_updated($config)
    {
        $host = 'api.newhost.com';

        $config->setHost($host);

        $this->assertSame($config->getHost(), $host);
    }

    /**
     * @test
     * @depends a_new_config_config_can_be_created_with_valid_arguements
     */
    public function the_port_can_be_updated($config)
    {
        $port = 9101;

        $config->setPort($port);

        $this->assertSame($config->getPort(), $port);
    }

    /**
     * @test
     * @depends a_new_config_config_can_be_created_with_valid_arguements
     */
    public function the_package_version_can_be_updated($config)
    {
        $version = '7.0.0';

        $config->setPackageVersion($version);

        $this->assertSame($config->getPackageVersion(), $version);
    }
}
