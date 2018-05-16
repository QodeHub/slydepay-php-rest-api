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

namespace Qodehub\Slydepay;

use Qodehub\Slydepay\Config;

/**
 * Slydepay Class
 *
 * This is the main entry class for the Qodehub/Slydepay Package
 * This class is responsible for creating the config instance
 */
class Slydepay implements ConfigInterface
{
    /**
     * The package version.
     *
     * @var string
     */
    const VERSION = '1.0.0';
    /**
     * The package Client Name.
     *
     * @var string
     */
    const CLIENT = __NAMESPACE__;
    /**
     * The Config repository instance.
     *
     * @var \Qodehub\Slydepay\ConfigInterface
     */
    protected $config;

    /**
     * Constructor
     *
     * @param Config|array|string $data        This could either be the configuration
     *                                         instance, an array with the
     *                                         configuration data, or the merchant
     *                                         emailnor mobile number.
     * @param string              $merchantKey This will switch https on or off. Defaults to true
     */
    public function __construct($data = null, $merchantKey = null)
    {
        /**
         * Check if a configuration instance was passed in.
         */
        if ($data instanceof Config) {
            /**
             * Set the configutation on the instance
             * if this test passed.
             */

            return $this->setConfig($data);
        }

        /**
         * Check if an array was passed and with key and values
         */
        if (is_array($data)) {
            /**
             * Build the configuration instance from
             * the array data if this
             * test passed.
             */

            return $this->setConfig(
                new Config($data['emailOrMobileNumber'], $data['merchantKey'])
            );
        }

        /**
         * If the data was not an array, or a
         * Config instance, then we can asume
         * that the the configuration data
         * was passed accordingly.
         */

        return $this->setConfig(
            new Config($data, $merchantKey)
        );
    }
    /**
     * Create a new Qodehub Instance
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
     * @return \Qodehub\Slydepay\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }
    /**
     * Sets the Config repository instance.
     *
     * @param  \Qodehub\Slydepay\ConfigInterface $config
     * @return $this
     */
    public function setConfig(ConfigInterface $config)
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
     * Dynamically handle allowed magic static method calls.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return \OVAC\HubtelPayment\Api\Transaction
     */
    public static function __callStatic($method, $parameters)
    {
        return (new self)->getApiInstance($method, ...$parameters);
    }
    /**
     * Dynamically handle allowed magic-method calls.
     *
     * @param  string $method
     * @param  array  $parameters
     * @return \OVAC\HubtelPayment\Api\Transaction
     */
    public function __call($method, array $parameters)
    {
        return $this->getApiInstance($method, ...$parameters);
    }

    /**
     * Returns the class instance for the given method if it
     * falls within the allowed methods.
     *
     * @param  string $method
     * @return \Qodehub\Slydepay\Api\Transaction
     * @throws \BadMethodCallException
     */
    protected function getApiInstance($method, ...$parameters)
    {

        /**
         * Append a capitalized name of the method
         * passed in, to create a class address
         *
         * @var string
         */
        $class = '\\Qodehub\\Slydepay\\Api\\' . ucwords($method);

        /**
         * Check if the class exists
         */
        if (class_exists($class)) {
            /**
             * Create a new instance of the class
             * since it exists and is in the
             * list of allowed magic
             * methods lists.
             */
            $executionInstace = new $class(...$parameters);

            /**
             * Inject the Api configuration if
             * any exists on the chain.
             */
            if ($this->getConfig() instanceof Config) {
                $executionInstace->injectConfig($this->getConfig());
            }

            return $executionInstace;
        }

        throw new \BadMethodCallException('Undefined method [ ' . $method . '] called.');
    }
}
