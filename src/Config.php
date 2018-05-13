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
}
