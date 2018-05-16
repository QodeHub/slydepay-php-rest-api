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
 *
 */
class CreateAndSendInvoice extends Api
{
    use MassAssignable;
    use CanCleanParameters;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'amount',
        'orderCode',
        'payOption',
        'customerName',
        'customerEmail',
        'customerMobileNumber',
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'description',
        'orderItems',
    ];

    /**
     * Mandatory Invoice amount, total order fee.
     * @var float
     */
    protected $amount;

    /**
     * Mandatory Specifies to slydepay to send the invoice
     * to your customer. Mandatory in this context
     * @var bool
     */
    protected $sendInvoice;
    /**
     * Mandatory The payment option selected by you, a channel you wish to receive payment
     * from. It's Mandatory in this context of sending invoice. It needs to be the
     * shortname field of =the document returned by the ListPayOptions API call
     * @var string
     */
    protected $payOption;
    /**
     * Mandatory The name of your customer. It's Mandatory
     * in this context of sending invoice.
     * @var string
     */
    protected $customerName;
    /**
     * Mandatory The email of your customer. But if Mobile
     * Payment payoption is selected it's not needed.
     * @var string
     */
    protected $customerEmail;
    /**
     * Mandatory The phone number of your customer. This is also
     * mandatory only if you using mobile payment payoption
     * @var string
     */
    protected $customerMobileNumber;
    /**
     * Mandatory Your merchnat order unique Id generated by/in your system.
     * @var string
     */
    protected $orderCode;
    /**
     * Optional List of Items that will be shown the to your customer on the payment page
     * @var array
     */
    protected $orderItems;
    /**
     * Optional Description for the order or for the items of the order/invoice
     * @var string
     */
    protected $description;
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
     * Set the total amount for the invoice
     * @param  number $amount The amount
     * @return self
     */
    public function amount($amount)
    {
        return $this->setAmount($amount);
    }

    /**
     * The  mobile number of the customer you want to bill
     *
     * @param  string $customerMobileNumber This is the Customer Msisdn
     * @return self
     */
    public function from($customerMobileNumber)
    {
        return $this->customerMobileNumber($customerMobileNumber);
    }

    /**
     * The  mobile number of the customer you want to bill
     *
     * @param  string $customerMobileNumber This is the Customer Msisdn
     * @return self
     */
    public function customerMobileNumber($customerMobileNumber)
    {
        return $this->setCustomerMobileNumber($customerMobileNumber);
    }

    /**
     * Set the description of the transaction
     *
     * @param  string $description The description of the transaction
     * @return self
     */
    public function description($description)
    {
        return $this->setDescription($description);
    }
    /**
     * Set the pay option for the invoice
     *
     * @param  string $payOption The payOption of the transaction
     * @return self
     */
    public function payOption($payOption)
    {
        return $this->setPayOption($payOption);
    }
    /**
     * Set the order items
     *
     * @param  array $orderItems The orderItems
     * @return self
     */
    public function orderItems(array $orderItems)
    {
        return $this->setOrderItems($orderItems);
    }
    /**
     * Sets the order code.
     *
     * @param  string|number $orderCode the orderCode
     * @return self
     */
    public function orderCode($orderCode)
    {
        return $this->setOrderCode($orderCode);
    }
    /**
     * Sets the customer name as required by the Hubtel Receive Api
     * (requred by the Hubtel ReceiveMoney Api)
     *
     * @param  string $customerName The full name of the customer being charged
     * @return self
     */
    public function customerName($customerName)
    {
        return $this->setCustomerName($customerName);
    }
    /**
     * Sets the customer email (Optional)
     *
     * @param  string $customerEmail The email of the customer to be charged
     * @return self
     */
    public function customerEmail($customerEmail)
    {
        return $this->setCustomerEmail($customerEmail);
    }

    /**
     * @return bool
     */
    public function getSendInvoice()
    {
        return $this->sendInvoice;
    }

    /**
     * @param bool $sendInvoice
     *
     * @return self
     */
    public function setSendInvoice(bool $sendInvoice)
    {
        $this->sendInvoice = $sendInvoice;

        return $this;
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
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderCode()
    {
        return $this->orderCode;
    }

    /**
     * @param string $orderCode
     *
     * @return self
     */
    public function setOrderCode($orderCode)
    {
        $this->orderCode = $orderCode;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_post(
            'invoice/create',
            $this->propertiesToArray()
        );
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return array
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }

    /**
     * @param array $orderItems
     *
     * @return self
     */
    public function setOrderItems(array $orderItems)
    {
        $this->orderItems = $orderItems;

        return $this;
    }
}
