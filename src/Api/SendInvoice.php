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

use Qodehub\Slydepay\Utility\CanCleanParameters;
use Qodehub\Slydepay\Utility\MassAssignable;

/**
 * ListPayOptions Class
 */
class SendInvoice extends CreateAndSendInvoice
{
    use MassAssignable;
    use CanCleanParameters;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'payToken',
        'payOption',
        'customerName',
        'customerEmail',
        'customerMobileNumber',
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'externalAccountRef',
    ];

    /**
     * Mandatory Paytoken returned by Slydepay.
     *
     * @var string
     */
    protected $payToken;
    /**
     * Mandatory The payment option selected by you, a channel you wish to receive payment
     * from. It's Mandatory in this context of sending invoice. It needs to be the
     * shortname field of =the document returned by the ListPayOptions API call
     *
     * @var string
     */
    protected $payOption;
    /**
     * Mandatory The name of your customer. It's Mandatory
     * in this context of sending invoice.
     *
     * @var string
     */
    protected $customerName;
    /**
     * Mandatory The email of your customer. But if Mobile
     * Payment payoption is selected it's not needed.
     *
     * @var string
     */
    protected $customerEmail;
    /**
     * Mandatory The phone number of your customer. This is also
     * mandatory only if you using mobile payment payoption
     *
     * @var string
     */
    protected $customerMobileNumber;

    /**
     * Construct for creating a new instance of this class
     *
     * @param array|string $data An array with assignable Parameters or an
     *                           Address or an addressID
     */
    public function __construct($data = null)
    {
        $this->massAssign($data);
    }

    /**
     * Set the pay Token for the invoice
     *
     * @param  string $payToken The payToken of the transaction
     * @return self
     */
    public function payToken($payToken)
    {
        return $this->setPayToken($payToken);
    }

    /**
     * @return string
     */
    public function getPayOption()
    {
        return $this->payOption;
    }

    /**
     * @param string $payOption
     *
     * @return self
     */
    public function setPayOption($payOption)
    {
        $this->payOption = $payOption;

        return $this;
    }

    /**
     * @return string
     */
    public function getPayToken()
    {
        return $this->payToken;
    }

    /**
     * @param string $payToken
     *
     * @return self
     */
    public function setPayToken($payToken)
    {
        $this->payToken = $payToken;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param string $customerName
     *
     * @return self
     */
    public function setCustomerName($customerName)
    {
        $this->customerName = $customerName;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerEmail()
    {
        return $this->customerEmail;
    }

    /**
     * @param string $customerEmail
     *
     * @return self
     */
    public function setCustomerEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerMobileNumber()
    {
        return $this->customerMobileNumber;
    }

    /**
     * @param string $customerMobileNumber
     *
     * @return self
     */
    public function setCustomerMobileNumber($customerMobileNumber)
    {
        $this->customerMobileNumber = $customerMobileNumber;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_post(
            'invoice/send',
            $this->propertiesToArray()
        );
    }
}
