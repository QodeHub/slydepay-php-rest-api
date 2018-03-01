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

namespace Qodehub\Bitgo\Tests\Unit\Api/Wallet;

use Mockery as m;
use PHPUnit\Framework\TestCase;

/**
 * Api/Wallet Test
 *
 * Test case for Api/Wallet class
 */
class Test extends TestCase
{
    /**
     * Filter list by Enterprise ID.
     *
     * @var string
     */
    protected $enterpriseId;
    /**
     * Setup resources and dependencies
     *
     * @return void
     */
    public function setUp()
    {
        //
    }
    /**
     * Close mockery.
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }
}
