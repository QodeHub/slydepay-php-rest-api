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
use Qodehub\Slydepay\Api\CreateAndSendInvoice;
use Qodehub\SlydePay\SlydePay;

class CreateAndSendInvoiceTest extends TestCase
{

    /** @test */
    public function the_createInvoice_method_should_return_a_createInvoice_instance()
    {
        $instance = SlydePay::createAndSendInvoice();

        $this->assertInstanceOf(CreateAndSendInvoice::class, $instance);
    }
}
