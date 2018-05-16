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

    /** @test */
    public function the_listPayOptions_method_should_return_a_listPayOptions_instance()
    {
        $instance = SlydePay::sendInvoice();

        $this->assertInstanceOf(SendInvoice::class, $instance);
    }
}
