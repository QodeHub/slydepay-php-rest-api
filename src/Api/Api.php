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

namespace Qodehub\Slydepay\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\uri_template;
use Qodehub\Slydepay\Config;
use Qodehub\Slydepay\ConfigInterface;
use Qodehub\Slydepay\Exception\Handler;
use Qodehub\Slydepay\Utility\SlydepayHandler;

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
     * @var \Qodehub\Slydepay\ConfigInterface
     */
    protected $config;
    /**
     * The default base URL for the Slydepay API
     *
     * @var string
     */
    protected $baseUrl = 'https://app.slydepay.com.gh';
    /**
     * The default basePath on the API instance
     *
     * @var string
     */
    protected $basePath = '/api/merchant/';
    /**
     * This is the response received from the bitgo server
     * if no exception was thrown.
     *
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $response;

    /**
     * Constructor.
     *
     * @param  \Qodehub\Slydepay\ConfigInterface $config
     * @return void
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Injects the configuration to the Api Instance
     *
     * @param  \Qodehub\Slydepay\ConfigInterface $config
     * @return self
     */
    public function injectConfig(Config $config)
    {
        return $this->setConfig($config);
    }
    /**
     * Change the Default Api basePath
     *
     * @param  string $basePath The Bitgo Resource Base Path
     * @return self
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;

        return $this;
    }
    /**
     * Get the Bitgo payment Base Path from the Api Instance
     *
     * @return string [This is the base Path that is on the class instance]
     */
    public function getBasePath()
    {
        return $this->basePath;
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
     * @throws \Handler
     */
    public function execute($httpMethod, $url, array $parameters = [])
    {
        $this->checkConfig();

        try {
            $this->response = $this->getClient($parameters += $this->config->toArray())->{$httpMethod}(

                \GuzzleHttp\uri_template(

                    $this->getBasePath() . $url,
                    $parameters
                ),
                [
                    'json' => $parameters,
                ]
            );

            return json_decode((string) $this->response->getBody());
        } catch (ClientException $e) {
            throw new Handler($e);
        }
    }
    /**
     * Returns an Http client instance.
     *
     * @return \GuzzleHttp\Client
     */
    protected function getClient($parameters)
    {
        return new Client(
            [
                'base_uri' => $this->baseUrl,
                'handler' => $this->createHandler($this->config),
                $parameters,

            ]
        );
    }

    /**
     * Create the client handler.
     *
     * @param  \Qodehub\Slydepay\Config $config
     * @return \GuzzleHttp\HandlerStack
     */
    protected function createHandler(Config $config)
    {
        return (new SlydepayHandler($config))->createHandler();
    }

    /**
     * @return \Qodehub\Slydepay\ConfigInterface
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param \Qodehub\Slydepay\ConfigInterface $config
     *
     * @return self
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * This funciton will check the configuration instance for required
     * parameters before allowing the execution
     *
     * @return boolean
     * @throws \RuntimeException
     * @throws \Qodehub\Slydepay\Exception\MissingParameterException
     */
    public function checkConfig()
    {
        if ($this->config instanceof Config) {

            return $this->config->testValues();
        }

        throw new \RuntimeException('The API requires a configuration instance.');
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
