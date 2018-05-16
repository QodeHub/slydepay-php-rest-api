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
use Qodehub\Slydepay\Api\ListPayOptions;
use Qodehub\SlydePay\SlydePay;

class ListPayOptionsTest extends TestCase
{

    /** @test */
    public function the_listPayOptions_method_should_return_a_listPayOptions_instance()
    {
        $instance = SlydePay::listPayOptions();

        $this->assertInstanceOf(ListPayOptions::class, $instance);
    }
}
