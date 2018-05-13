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

namespace Qodehub\Slydepay\Utility;

/**
 * MassAssignable Trait
 *
 * looks through fillable fields and matches them with provided
 * to enable mass assignment option using a constructor
 * or a make function.
 */
trait MassAssignable
{
    /**
     * This method is used to mass assign the properties required in a class.
     *
     * How does this happen? Magic! naaaaaa.
     *
     * It loops through the fields marked as required and optional
     * and then assisngs values to those fields using accessors
     * available in the class for those required options.
     *
     * @param   array $data
     * @example [
     *              'walletId' => 'some-existing-walletId',
     *              'transactionId' => 'someExistingTransactionId'
     *          ]
     * @return  self
     */
    protected function massAssign($data = [])
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                if (method_exists($this, 'set' . $key)
                    && in_array($key, array_merge($this->parametersRequired, $this->parametersOptional))
                ) {
                    $this->{'set' . $key}($value);
                }
            }
        }

        return $this;
    }
}
