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

use Qodehub\Bitgo\Bitgo;
use Qodehub\Bitgo\ConfigInterface;

/**
 * Config Class
 *
 * This class holds the instance confuguration
 * and the methods required to update or retrieve
 * required configuration data.
 */
class Config implements ConfigInterface
{
    /**
     * This Package Version.
     *
     * @var string
     */
    protected $version;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setPackageVersion(Bitgo::VERSION);
    }
    /**
     * {@inheritdoc}
     */
    public function getPackageVersion()
    {
        return $this->version;
    }
    /**
     * {@inheritdoc}
     */
    public function setPackageVersion($version)
    {
        $this->version = $version;

        return $this;
    }
}
