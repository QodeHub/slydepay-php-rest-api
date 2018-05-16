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

namespace Qodehub\Slydepay\Api;

use Qodehub\Slydepay\Utility\CanCleanParameters;
use Qodehub\Slydepay\Utility\MassAssignable;

/**
 * ListPayOptions Class
 */
class ListPayOptions extends Api
{
    use MassAssignable;
    use CanCleanParameters;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
    ];

    /**
     * Construct for creating a new instance of this class
     *
     * @param array|string $data An array with assignable Parameters or an
     *                           Address or an addressID
     */
    public function __construct($data = null)
    {
        $this->massAssign($data);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_post(
            'invoice/payoptions',
            $this->propertiesToArray()
        );
    }
}
