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

namespace qodehub\Bitgo\Tests\Unit;

use Mockery as m;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{

    /**
     * The Qodehub\Bitgo Pay config.
     *
     * @var \Qodehub\Bitgo\Config
     */
    protected $config;
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
