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

namespace Qodehub\Bitgo\Exception;

/**
 * Class BitgoException
 * throws Qodehub\Bitgo\Exception\BitgoException
 */
class BitgoException extends \Exception
{
    /**
     * The error code returned by Bitgo.
     *
     * @var string
     */
    protected $errorCode;
    /**
     * The error type returned by Bitgo.
     *
     * @var string
     */
    protected $errorType;
    /**
     * The missing parameter returned by Bitgo.
     *
     * @var string
     */
    protected $missingParameter;
    /**
     * The raw output returned by Bitgo in case of exception.
     *
     * @var string
     */
    protected $rawOutput;
    /**
     * Returns the error type returned by Bitgo.
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }
    /**
     * Sets the error type returned by Bitgo.
     *
     * @param  string $errorCode
     * @return self
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;

        return $this;
    }
    /**
     * Returns the error type returned by Bitgo.
     *
     * @return string
     */
    public function getErrorType()
    {
        return $this->errorType;
    }
    /**
     * Sets the error type returned by Bitgo.
     *
     * @param  string $errorType
     * @return self
     */
    public function setErrorType($errorType)
    {
        $this->errorType = $errorType;

        return $this;
    }
    /**
     * Returns missing parameter returned by Bitgo with the error.
     *
     * @return string
     */
    public function getMissingParameter()
    {
        return $this->missingParameter;
    }
    /**
     * Sets the missing parameter returned by Bitgo with the error.
     *
     * @param  string $missingParameter
     * @return self
     */
    public function setMissingParameter($missingParameter)
    {
        $this->missingParameter = $missingParameter;

        return $this;
    }
    /**
     * Returns raw output returned by Bitgo in case of exception.
     *
     * @return string
     */
    public function getRawOutput()
    {
        return $this->rawOutput;
    }
    /**
     * Sets the raw output parameter returned by Bitgo in case of exception.
     *
     * @param  string $rawOutput
     * @return self
     */
    public function setRawOutput($rawOutput)
    {
        $this->rawOutput = $rawOutput;

        return $this;
    }
}
