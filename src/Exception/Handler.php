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

namespace Qodehub\Slydepay\Exception;

use GuzzleHttp\Exception\ClientException;

/**
 * Class Handler
 *
 * Handles Bitgo Exceptions
 * throws \Qodehub\Slydepay\Exception\SlydepayException
 */
class Handler
{
    /**
     * List of mapped exceptions and their corresponding status codes.
     *
     * @var array
     */
    protected $excByStatusCode = [
        // Often missing a required parameter
        400 => 'BadRequest',
        // Invalid ClientID and ClientSecret provided
        401 => 'Unauthorized',
        // Parameters were valid but request failed
        402 => 'InvalidRequest',
        // The requested resource doesn't exist
        404 => 'NotFound',
        // Something went wrong on the bitgo server
        500 => 'ServerError',
        502 => 'ServerError',
        503 => 'ServerError',
        504 => 'ServerError',
    ];
    /**
     * Constructor.
     *
     * @param  \GuzzleHttp\Exception\ClientException $exception
     * @throws \Qodehub\Slydepay\Exception\SlydepayException
     */
    public function __construct(ClientException $exception)
    {
        $response = $exception->getResponse();
        $statusCode = $response->getStatusCode();
        $rawOutput = json_decode($response->getBody(true), true);
        $error = $rawOutput ?: [];
        $errorCode = isset($error['ResponseCode']) ? $error['ResponseCode'] : null;
        $errorType = isset($error['type']) ? $error['type'] : null;
        $message = isset($error['Message']) ? $error['Message'] : null;
        $missingParameter = isset($error['Error']) ? $this->getMissingParameters($error['Error']) : null;

        $exception = $this->handleException(
            $message,
            $statusCode,
            $errorType,
            $errorCode,
            $missingParameter,
            $rawOutput
        );

        throw $exception;
    }
    /**
     * Guesses the FQN of the exception to be thrown.
     *
     * @param  string $message
     * @param  int    $statusCode
     * @param  string $errorType
     * @param  string $errorCode
     * @param  array  $missingParameter
     * @return \Qodehub\Slydepay\Exception\SlydepayException
     *
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    protected function handleException($message, $statusCode, $errorType, $errorCode, $missingParameter, $rawOutput)
    {
        if ($statusCode === 400 && $errorCode == 4010) {
            $class = 'MissingParameter';
        } elseif (array_key_exists($statusCode, $this->excByStatusCode)) {
            $class = $this->excByStatusCode[$statusCode];
        } else {
            $class = 'Slydepay';
        }

        $class = '\\Qodehub\\Slydepay\\Exception\\' . $class . 'Exception';
        $instance = new $class($message, $statusCode);
        $instance->setErrorCode($errorCode);
        $instance->setErrorType($errorType ?: $class);
        $instance->setMissingParameter($missingParameter);
        $instance->setRawOutput($rawOutput);

        return $instance;
    }

    protected function getMissingParameters($errors = [])
    {
        $missingParameters = [];

        foreach ($errors as $err) {
            if (isset($err['Field'])) {
                $missingParameters[] = $err['Field'];
            }
        }

        return implode($missingParameters, ', ');
    }
}
