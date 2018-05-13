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

namespace Qodehub\Slydepay\Laravel;

use Illuminate\Support\ServiceProvider;
use Qodehub\Slydepay\Config;
use Qodehub\Slydepay\Slydepay;

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

        $this->mergeConfigFrom($config, 'qodehub.slydepay');

        $this->publishes(
            [
            $config => config_path('qodehub.slydepay.php'),
            ], 'config'
        );
    }

    /**
     * Binds this package with the Laravel Application.
     *
     * @return void
     */
    public function register()
    {
        $this->prepareResources();

        $this->app->bind(
            'qodehub.slydepay', function () {

                return new Slydepay(
                    new Config(
                        (string) config('qodehub.slydepay.email-or-phone'),
                        (string) config('qodehub.slydepay.merchant-key')
                    )
                );
            }
        );
    }
}
