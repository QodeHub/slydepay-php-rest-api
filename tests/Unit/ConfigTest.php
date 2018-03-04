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

namespace Qodehub\Bitgo\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;

class ConfigTest extends TestCase
{
    /**
     * A configuration instance to be used by the api
     * @var Qodehub\Bitgo\Config
     */
    protected $config;

    /** @test */
    public function a_new_config_instance_can_be_created()
    {
        $this->config = new Config();

        $this->assertTrue(true);
    }
}
