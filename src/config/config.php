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

return [
    /*
    |--------------------------------------------------------------------------
    | Slydepay merchant Email or Phone Number
    |--------------------------------------------------------------------------
    |
    | Please provide your Slydepay merchant email or phone number
    |
     */
    'email-or-phone' => env('SLYDEPAY_EMAIL_OR_PHONE'),
    /*
    |--------------------------------------------------------------------------
    | Slydepay merchant Key
    |--------------------------------------------------------------------------
    |
    | Please provide your Slydepay merchant key
    |
     */
    'merchant-key' => env('SLYDEPAY_MERCHANT_KEY', 'localhost'),
];
