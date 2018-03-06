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

namespace Qodehub\Bitgo\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\ConfigInterface;
use Qodehub\Bitgo\Exception\Handler;
use Qodehub\Bitgo\Exception\MissingParameterException;
use Qodehub\Bitgo\Utility\BitgoHandler;

/**
 * Api Class
 *
 * This class in responsible for making and executing the calls
 * to the Bitgo Server.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
abstract class Api implements ApiInterface
{
    /**
     * The Config repository instance.
     *
     * @var \Qodehub\Bitgo\ConfigInterface
     */
    protected $config;
    /**
     * The Default Bitgo Base Api url
     *
     * @var string
     */
    protected $baseUrl = 'https://www.bitgo.com/api/v2';
    /**
     * This is the response received from the bitgo server
     * if no exception was thrown.
     *
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $response;
    /**
     * This will be changed to true in child classes that use
     * the CurrencyTrait.
     *
     * @var boolean
     */
    protected $isCoinPath = false;
    /**
     * Injects the configuration to the Api Instance
     *
     * @param  \Qodehub\Bitgo\ConfigInterface $config
     * @return self
     */
    public function injectConfig(Config $config)
    {
        return $this->setConfig($config);
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
     * Get the Bitgo payment Base Url from the Api Instance
     *
     * @return string [This is the base URL that is on the class instance]
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }
    /**
     * {@inheritdoc}
     */
    public function _get($url = null, $parameters = [])
    {
        return $this->execute('get', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function _head($url = null, array $parameters = [])
    {
        return $this->execute('head', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function _delete($url = null, array $parameters = [])
    {
        return $this->execute('delete', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function _put($url = null, array $parameters = [])
    {
        return $this->execute('put', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function _patch($url = null, array $parameters = [])
    {
        return $this->execute('patch', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function _post($url = null, array $parameters = [])
    {
        return $this->execute('post', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     */
    public function _options($url = null, array $parameters = [])
    {
        return $this->execute('options', $url, $parameters);
    }
    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException
     * @throws \Handler
     */
    public function execute($httpMethod, $url, array $parameters = [])
    {
        if ($this->config instanceof Config) {
            try {
                $this->response = $this->getClient()->{$httpMethod}($url, [
                    'json' => $parameters,
                ]);

                return json_decode((string) $this->response->getBody(), true);
            } catch (ClientException $e) {
                throw new Handler($e);
            }

            return;
        }

        throw new \RuntimeException('The API requires a configuration instance.');
    }
    /**
     * Returns an Http client instance.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getClient()
    {
        return new Client(
            [
                'base_uri' => $this->baseUrl . $this->skipOrAppendCoin(),
                'handler' => $this->createHandler($this->config),
            ]
        );
    }

    /**
     * Create the client handler.
     *
     * @param  \Qodehub\Bitgo\Config $config
     * @return \GuzzleHttp\HandlerStack
     */
    protected function createHandler(Config $config)
    {
        return (new BitgoHandler($config))->createHandler();
    }

    /**
     * @return \Qodehub\Bitgo\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param \Qodehub\Bitgo\ConfigInterface $config
     *
     * @return self
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Skip or append coin path depending on if
     * the isCoinPath was changed to true by
     * a child class.
     * @return string|null the coin path partial
     */
    public function skipOrAppendCoin()
    {
        if ($this->isCoinPath) {

            /**
             * Validate that there is a value on the coin
             * Api
             */
            if ($this->coin) {
                return '/' . $this->coin;
            }

            throw new MissingParameterException(
                str_replace('The coin value is required.')
            );
        }
    }

    /**
     * This method will hit the run request with any arguement passed into it
     * It can be used interchangably with the run, get or post method.
     *
     * @param  any ...$args The list of args
     * @return self
     */
    public function get(...$args)
    {
        return $this->run(...$args);
    }
}
