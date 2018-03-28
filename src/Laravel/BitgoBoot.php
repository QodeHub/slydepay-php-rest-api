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

namespace Qodehub\Bitgo\Laravel;

use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;

/**
 * class LaravelHubtelPayment.
 *
 * This class extends the \Qodehub\Bitgo\Bitgo::class class and replaces
 * presets the config parameter with an a config instance using data
 * from the package laravel configuration.
 */
class BitgoBoot extends Bitgo
{
    public function getConfig()
    {
        return new Config(
            config('qodehub.bitgo.secret'),
            config('qodehub.bitgo.secure'),
            config('qodehub.bitgo.host')
        );
    }
}
