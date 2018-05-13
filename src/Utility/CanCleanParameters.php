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

use Qodehub\Slydepay\Exception\MissingParameterException;

/**
 * Trait CanCleanParameters
 */
trait CanCleanParameters
{
    /**
     * This method checks that all properties marked as
     * required have been assigned a value.
     *
     * A protected $parametersRequired property must contain the names of
     * the required parameters on the class that will use this trait method.
     * and all parameters must each have a defined get accessor on the
     * class object instance
     *
     * @return bool
     * @throws \Qodehub\Slydepay\Exception\MissingParameterException
     */
    protected function propertiesPassRequired()
    {
        $keys = '';

        foreach ($this->parametersRequired as $key) {
            if (is_null($this->accessPropertyByKey($key))) {
                $keys .= $key . ', ';
            }
        }

        if ($keys) {
            throw new MissingParameterException(
                str_replace(', .', '', 'The following parameters are required: ' . $keys . '.')
            );
        }
    }
    /**
     * This method picks up all the defined properties the
     * $parameterRequired|$parameterOptional property
     * array list from the class object and returns
     * an array containing each list item name as
     * a key and the matching property value from
     * the class
     *
     * @return array An array of parameters with values
     */
    protected function propertiesToArray()
    {
        $properties = [
            $this->parametersRequired,
            $this->parametersOptional,
        ];

        $cleanProperty = [];

        foreach ($properties as $array) {
            foreach ($array as $key) {
                if ($this->accessPropertyByKey($key)) {
                    $cleanProperty[$key] = $this->accessPropertyByKey($key);
                }
            }
        }

        return $cleanProperty;
    }
    /**
     * This method calls the accessors for keys passed in
     * and returns back the value it receives from the
     * class instance
     *
     * throws an error if a defined parameter in the
     * $parameterRequired|$parameterOptional does
     * not have a reachable get[PropertyName] accessor
     * defined on the class instance.
     *
     * @param  string $key /$parameterRequired[(*)]|$parameterOptional[(*)]/
     * @return mixed
     * @throws \BadMethodCallException
     */
    protected function accessPropertyByKey($key)
    {
        if (method_exists($this, 'get' . $key)) {
            return $this->{'get' . ucwords($key)}();
        }

        throw new \RuntimeException(
            'The ' . $key . ' parameter must have a defined get' . ucwords($key) . ' method.'
        );
    }
}
