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

namespace Qodehub\Bitgo;

use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\ConfigInterface;

/**
 * Config Class
 *
 * This class holds the instance confuguration
 * and the methods required to update or retrieve
 * required configuration data.
 *
 * @example new Config($bearerToken, $secure = true, $host = 'http://localhost', $port = 3080);
 */
class Config implements ConfigInterface
{
    /**
     * This Package Version.
     *
     * @var string
     */
    protected $version;
    /**
     * This will be the Authorization Token
     *
     * @var string
     */
    protected $token;
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
    protected $port;
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
    protected $scheme;
    /**
     * This is a base URL used in place of the URL.
     * When this is set, the cnofiguration will
     * ignore the secure and port flag.
     *
     * This must be a full base URL inlcuding
     * the port and path on which the
     * server is running.
     *
     * @example http://www.example.com:8090
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * Constructor
     *
     * This configuration constructor holds the config data.
     *
     * @param string  $token  This is your token from the Bitgo Server
     * @param boolean $secure This determines if the servere url should be HTTP(S)
     * @param string  $host   This is the reacable Bitgo Server
     * @param integer $port   This is the port for the reachable Bitgo server
     */
    public function __construct($token = null, $secure = 1, $host = 'test.bitgo.com', $port = null)
    {
        $this->setPackageVersion(Bitgo::VERSION);
        $this->setToken($token ?: getenv('BITGO_TOKEN'));
        $this->setHost($host ?: getenv('BITGO_HOST'));
        $this->setSecure($secure ?: (bool) getenv('BITGO_SECURE'));
        $this->setPort($port ?: getenv('BITGO_PORT'));
    }

    /**
     * This will build and return the API Endpoint using
     * the configuration or will give the baseURL
     * that has been set on the instance.
     *
     * @return string [This is the base URL that is on the class instance]
     */
    public function getBaseUrl()
    {
        $this->setScheme($this->isSecure() ? 'https' : 'http');

        return $this->baseUrl ?: $this->getScheme() . '://' . $this->getHost() . ($this->getPort() ? (':' . $this->getPort()) : null);
    }

    /**
     * Change the Default Api baseUrl
     *
     * @param  string $baseUrl The Bitgo Resource Base URL
     * @return self
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getPackageVersion()
    {
        return $this->version;
    }
    /**
     * {@inheritdoc}
     */
    public function setPackageVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return self
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSecure()
    {
        return $this->secure;
    }

    /**
     * @param boolean $secure
     *
     * @return self
     */
    public function setSecure($secure)
    {
        $this->secure = $secure;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     *
     * @return self
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param integer $port
     *
     * @return self
     */
    public function setPort(int $port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @param boolean $scheme
     *
     * @return self
     */
    public function setScheme($scheme)
    {
        $this->scheme = $scheme;

        return $this;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }
}
