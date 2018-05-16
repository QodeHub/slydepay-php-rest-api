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

namespace Qodehub\SlydePay\Tests\Unit\Api;

use PHPUnit\Framework\TestCase;
use Qodehub\Slydepay\Api\SendInvoice;
use Qodehub\SlydePay\SlydePay;

class SendInvoiceTest extends TestCase
{
    protected $payToken = 'payTokenValue';

    protected $payOption = 'payOptionValue';

    protected $customerName = 'customerNameValue';

    protected $customerMobileNumber = 'customerMobileNumberValue';

    protected $customerEmail = 'customerEmailValue';

    /** @test */
    public function the_send_invoice_method_can_be_mass_assigned()
    {
        $instance = SlydePay::sendInvoice([
            'payToken' => $this->payToken,
            'payOption' => $this->payOption,
            'customerName' => $this->customerName,
            'customerEmail' => $this->customerEmail,
            'customerMobileNumber' => $this->customerMobileNumber,
        ]);

        $this->assertSame($instance->getPayToken(), $this->payToken, 'The payToken should be the same as passed in');
        $this->assertSame($instance->getCustomerEmail(), $this->customerEmail, 'The customerEmail should be the same as passed in');
        $this->assertSame($instance->getCustomerName(), $this->customerName, 'The customerName should be the same as passed in');
        $this->assertSame($instance->getCustomerMobileNumber(), $this->customerMobileNumber, 'The customerMobileNumber should be the same as passed in');
        $this->assertSame($instance->getPayOption(), $this->payOption, 'The payOption should be the same as passed in');
    }
}
