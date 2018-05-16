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
class CancelTransaction extends ConfirmTransaction
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
        'transactionId',
        'orderCode',
        'payToken',
    ];
}
