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

use Qodehub\Bitgo\Config;

/**
 * Bitgo Class
 *
 * This is the main entry class for the Qodehub/Bitgo Package
 * This class is responsible for creating the config instance
 */
class Bitgo implements ConfigInterface
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '2.0.0';
    /**
     * The package Client Name.
     *
     * @var string
     */
    const CLIENT = __NAMESPACE__;
    /**
     * The Config repository instance.
     *
     * @var \Qodehub\Bitgo\ConfigInterface
     */
    protected $config;

    /**
     * Create a new Qodehub\Bitgo instance via constructor.
     */
    public function __construct()
    {
        $this->config = new Config();
    }
    /**
     * Create a new Qodehub Studio
     *
     * @return self A new class of self.
     */
    public static function make()
    {
        return new static();
    }
    /**
     * Returns the Config repository instance.
     *
     * @return \Qodehub\Bitgo\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }
    /**
     * Sets the Config repository instance.
     *
     * @param  \Qodehub\Bitgo\ConfigInterface $config
     * @return $this
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;

        return $this;
    }
    /**
     * {@inheritdoc}
     */
    public function getPackageVersion()
    {
        return $this->config->getPackageVersion();
    }
    /**
     * {@inheritdoc}
     */
    public function setPackageVersion($version)
    {
        $this->config->setPackageVersion($version);

        return $this;
    }
    /**
     * Dynamically handle missing Static Api Classes and Methods.
     *
     * @param  string $className
     * @param  array  $parameters
     * @return \Qodehub\Bitgo\Api\Transaction
     * @throws \BadMethodCallException
     */
    public static function __callStatic($className, array $parameters)
    {
        return (new self)->getApiInstance($className, ...$parameters);
    }
    /**
     * Dynamically handle missing Api Classes and Methods.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return \Qodehub\Bitgo\Api\Transaction
     */
    public function __call($method, array $parameters)
    {
        return $this->getApiInstance($method, ...$parameters);
    }
    /**
     * Returns the Api class instance for the given method.
     *
     * @param  string $className
     * @return \Qodehub\Bitgo\Api\Transaction
     * @throws \BadMethodCallException
     */
    protected function getApiInstance($className, ...$parameters)
    {
        $class = '\\Qodehub\\Bitgo\\Api\\' . ucwords($className);
        if (class_exists($class)) {
            return (new $class(...$parameters))->injectConfig($this->config);
        }
        throw new \BadMethodCallException('Undefined method [ ' . $className . '] called.');
    }
}
