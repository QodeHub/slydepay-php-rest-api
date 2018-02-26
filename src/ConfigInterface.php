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

namespace Qodehub\Bitgo;

/**
 *
 */
interface ConfigInterface
{
    /**
     * Returns the current package version.
     *
     * @return string
     */
    public function getPackageVersion();
    /**
     * Set the current package version
     *
     * @param string $version The version of this package
     */
    public function setPackageVersion($version);
}
