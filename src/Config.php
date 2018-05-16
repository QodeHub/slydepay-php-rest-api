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

use Qodehub\Slydepay\ConfigInterface;
use Qodehub\Slydepay\Utility\CanCleanParameters;

/**
 * Config Class
 *
 * This class holds the instance confuguration
 * and the methods required to update or retrieve
 * required configuration data.
 *
 * @example new Config($emailOrMobileNumber, $merchantKey);
 */
class Config implements ConfigInterface
{
    use CanCleanParameters;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'merchantKey',
        'emailOrMobileNumber',
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [];

    /**
     * This Package Version.
     *
     * @var string
     */
    protected $version;
    /**
     * This will be the Slidepay Merchant Token
     *
     * @var string
     */
    protected $merchantKey;
    /**
     * This is the Email Or MobileNumber for the Slydepay Merchant
     *
     * @var string
     */
    protected $emailOrMobileNumber;

    /**
     * Constructor
     *
     * This configuration constructor holds the config data.
     *
     * @param boolean $emailOrPhoneNumber This determines if the servere url should be HTTP(S)
     * @param string  $merchantKey        This is your Slydepay Merchant Key
     */
    public function __construct($emailOrPhoneNumber = null, $merchantKey = null)
    {
        $this->setPackageVersion(Slydepay::VERSION);
        $this->setEmailOrMobileNumber($emailOrPhoneNumber ?: getenv('SLYDEPAY_EMAIL_OR_PHONE'));
        $this->setMerchantKey($merchantKey ?: getenv('SLYDEPAY_MERCHANT_KEY'));
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
    public function getMerchantKey()
    {
        return $this->merchantKey;
    }

    /**
     * @param string $merchantKey
     *
     * @return self
     */
    public function setMerchantKey($merchantKey)
    {
        $this->merchantKey = $merchantKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailOrMobileNumber()
    {
        return $this->emailOrMobileNumber;
    }

    /**
     * @param string $emailOrMobileNumber
     *
     * @return self
     */
    public function setEmailOrMobileNumber($emailOrMobileNumber)
    {
        $this->emailOrMobileNumber = $emailOrMobileNumber;

        return $this;
    }

    /**
     * Tests that the required configuration parameters
     * have been pased in and put in place.
     *
     * This is best used before any actual execution
     * of the class for doing validation.
     *
     * @return bool
     * @throws \Qodehub\Slydepay\Exception\MissingParameterException
     */
    public function testValues()
    {
        $this->propertiesPassRequired();

        return true;
    }
    /**
     * Give an array representation of the required configuration data
     * @return array
     */
    public function toArray()
    {
        return $this->propertiesToArray();
    }
}
