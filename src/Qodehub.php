<?php

/**
 * @package     Qodehub\Bitgo
 * @link        https://github.com/qodehub/qodehub-php
 *
 * @author      Ariama O. Victor (ovac4u) <victorariama@qodehub.com>
 * @link        http://www.ovac4u.com
 *
 * @license     https://github.com/qodehub/qodehub-php/blob/master/LICENSE
 * @copyright   (c) 2018, QodeHub, Ltd
 */

namespace Qodehub\Bitgo;

use Qodehub\Bitgo\Coin;
use Qodehub\Bitgo\Config;

/**
 * Qodehub Class
 *
 * This is the main entry class for the Qodehub/Qodehub Package
 * This class is responsible for creating the config instance
 */
class Qodehub implements ConfigInterface
{
    use Coin;

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
     * Constructor
     *
     * @param Config|array|string $data   This could either be the configuration
     *                                    instance, an array with the
     *                                    configuration data, or the bearer
     *                                    token.
     * @param boolean             $secure This will switch https on or off. Defaults to true.
     * @param string              $host   this is a string of the host address excluding the scheme and port
     * @param integer             $port   This is the Api port.
     */
    public function __construct($data = null, $secure = null, $host = null, $port = null)
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
                new Config($data['token'], $data['secure'], $data['host'], $data['port'])
            );
        }

        /**
         * If the data was not an array, or a
         * Config instance, then we can asume
         * that the the configuration data
         * was passed accordingly.
         */

        return $this->setConfig(
            new Config($data, $secure, $host, $port)
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
     * Dynamically handle missing Api Classes and Methods.
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
     * @return \Qodehub\Bitgo\Api\Transaction
     * @throws \BadMethodCallException
     *
     * @example \Qodehub\Bitgo::createWallet()->run();
     * @example \Qodehub\Bitgo::wallet()->getBalance()->run();
     * @example \Qodehub\Bitgo::wallet()->transactions()->get();
     * @example \Qodehub\Bitgo::setConfig($config)->wallet()->getBalance()->run();
     */
    protected function getApiInstance($method, ...$parameters)
    {
        /**
         * Restrict the possible methods that can be called.
         * Reason: so that unexpected behavious like
         * mis-spelling errors can be caught and
         * also -- Private and protected methods
         * can stay private and protected.
         *
         * I hope you get the basic idea! ;-)
         */
        if (in_array($method, ['wallet', 'createWallet'])) {

            /**
             * Append a capitalized name of the method
             * passed in, to create a class address
             *
             * @var string
             */
            $class = '\\Qodehub\\Qodehub\\' . ucwords($method);

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
                 * Inject the coin type
                 */
                $executionInstace->coinType($this->getCoinType());

                /**
                 * Inject the Api configuration if
                 * any exists on the chain.
                 */
                if ($this->config instanceof Config) {
                    $executionInstace->injectConfig($this->config);
                }

                return $executionInstace;
            }
        }

        throw new \BadMethodCallException('Undefined method [ ' . $method . '] called.');
    }
}
