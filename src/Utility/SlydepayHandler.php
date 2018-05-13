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

namespace Qodehub\Slydepay\Utility;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Qodehub\Slydepay\Config;
use Qodehub\Slydepay\Exception\Handler;
use Qodehub\Slydepay\Slydepay;

/**
 * Slidepay Handler Class
 *
 * This class holds the Slidepay handler and can
 * be used with any Guzzle client to queue
 * requests and middlewares.
 *
 * @see http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html Guzzle: Handlers and Middlewares.
 *
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class SlydepayHandler
{
    /**
     * Property for holding the handler stack on the instance
     *
     * @var \GuzzleHttp\HandlerStack
     */
    protected $stack;
    /**
     * Holds the configuration object
     *
     * @var \Qodehub\Slydepay\Config
     */
    protected $config;
    /**
     * Constructor for the SlydepayHandler class
     *
     * @param \Qodehub\Slydepay\Config $config
     * @param \GuzzleHttp\HandlerStack $stack
     */
    public function __construct(Config $config, HandlerStack $stack = null)
    {
        $this->config = $config;
        $this->stack = $stack ?: HandlerStack::create();
    }
    /**
     * Create the client handler.
     *
     * @return \GuzzleHttp\HandlerStack
     * @see    http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html Guzzle: Handlers and Middlewares.
     */
    public function createHandler()
    {
        $this->pushHeaderMiddleware(
            function (RequestInterface $request) {
                return $request->withHeader('User-Agent', Slydepay::CLIENT . ' v' . Slydepay::VERSION);
            }
        );

        $this->pushRetryMiddleware(self::decider(), self::delay());

        return $this->stack;
    }
    /**
     * Push the Header Middleware to the Handler Stack
     *
     * @param  callable $header Function that accepts a Guzzle RequestInterface
     *                     and returns a RequestInterface.
     * @return \GuzzleHttp\HandlerStack
     * @see    http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html Guzzle: Handlers and Middlewares.
     */
    protected function pushHeaderMiddleware(callable $header)
    {
        $this->stack->push(
            Middleware::mapRequest($header),
            'Slydepay-header-userAgent'
        );

        return $this->stack;
    }
    /**
     * Pushes a Retry Middleware to the Guzzle Client Handler Stack.
     *
     * Middleware that retries requests based on the boolean result of
     * invoking the provided "decider" function.
     *
     * If no delay function is provided, a simple implementation of exponential
     * backoff will be utilized.
     *
     * @param  callable $decider Function that accepts the number of retries,
     *                          a request, [response], and [exception] and
     *                          returns true if the request is to be retried.
     * @param  callable $delay   Function that accepts the number of retries and
     *                          returns the number of milliseconds to delay.
     * @return \GuzzleHttp\HandlerStack
     * @see    http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html Guzzle: Handlers and Middlewares.
     */
    protected function pushRetryMiddleware(callable $decider, callable $delay = null)
    {
        $this->stack->push(
            Middleware::retry($decider, $delay),
            'slydepay-retry-request'
        );

        return $this->stack;
    }
    /**
     * Function $decider callable
     *
     * Retuens a function that accepts the number of retries,
     * a request, [response], and [exception] and
     * returns true if the request is to be retried.
     *
     * @return callable $decider
     * @see    http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html Guzzle: Handlers and Middlewares.
     */
    protected static function decider()
    {

        /**
         * Function $decider callable
         *
         * This Function accepts the number of retries,
         * a request, [response], and [exception] and
         * returns true if the request is to be retried.
         *
         * @param  number                                   $retries The number of times left to retry
         * @param  \Psr\Http\Message\RequestInterface       $request The request Object
         * @param  \Psr\Http\Message\ResponseInterface      $response The response Object
         * @param  \GuzzleHttp\Exception\TransferException $exception Guzzle Response Exception Object
         * @return boolean This boolean determines if to retry or not.
         * @see    http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html Guzzle: Handlers and Middlewares.
         */

        return function (
            $retries,
            RequestInterface $request,
            ResponseInterface $response = null,
            TransferException $exception = null
        ) {
            return ($retries < 3) && ($exception instanceof ConnectException || (
                $response && $response->getStatusCode() >= 500
            )) && $request;
        };
    }
    /**
     * Function $delay
     *
     * returns a Function that accepts the number of retries and
     * returns the number of milliseconds to delay.
     *
     * The function is passed to the Retry Middleware as the second
     * arguement and then pushed into the handler stack.
     *
     * @see http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html Guzzle: Handlers and Middlewares.
     */
    protected static function delay()
    {
        /**
         * A Function that accepts the number of retries and
         * returns the number of milliseconds to delay.
         *
         * This function is passed to the Retry Middle ware as the second
         * argument and then pushed into the handler stack.
         *
         * @param  number $retries The number of times left to retry.
         * @return number The number of mili-seconds between the delay
         * @see    http://docs.guzzlephp.org/en/stable/handlers-and-middleware.html Guzzle: Handlers and Middlewares.
         */

        return function ($retries) {
            return (int) pow(2, $retries) * 1000;
        };
    }
}
