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

use Illuminate\Support\ServiceProvider;
use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\Config;

/**
 * class PackageServiceProvider
 */
class PackageServiceProvider extends ServiceProvider
{
    /**
     * Inject the configurration for this package from the
     * application enviroment during boot.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Prepare the package resources.
     *
     * @return void
     */
    protected function prepareResources()
    {
        $config = realpath(__DIR__ . '/../config/config.php');

        $this->mergeConfigFrom($config, 'qodehub.bitgo');

        $this->publishes([
            $config => config_path('qodehub.bitgo.php'),
        ], 'config');
    }

    /**
     * Binds this package with the Laravel Application.
     *
     * @return void
     */
    public function register()
    {
        $this->prepareResources();

        $this->app->bind('qodehub.bitgo', function () {

            return new Bitgo(
                new Config(
                    (string) config('qodehub.bitgo.token'),
                    (boolean) config('qodehub.bitgo.secure'),
                    (string) config('qodehub.bitgo.host'),
                    (integer) config('qodehub.bitgo.port')
                )
            );
        });
    }
}
