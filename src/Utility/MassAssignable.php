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

namespace Qodehub\Bitgo\Utility;

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
     * @example ['a' => 10, 'b' => ['name' => 'victor', ...] ...etc ]
     * @return  self
     */
    protected function massAssign($data = [])
    {
        if (is_array($data)) {
            //TODO: Add methods to loop through for mass assignment.
        }

        return $this;
    }
}
