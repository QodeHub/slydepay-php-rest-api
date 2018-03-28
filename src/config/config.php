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

return [
    /*
    |--------------------------------------------------------------------------
    | Bitgo Secret Key Token
    |--------------------------------------------------------------------------
    |
    | Please provide your Bitgo secret key
    |
     */
    'token' => env('BITGO_TOKEN'),
    /*
    |--------------------------------------------------------------------------
    | Bitgo Express Server Host
    |--------------------------------------------------------------------------
    |
    | Please provide your Bitgo-Express Host Url
    |
     */
    'host' => env('BITGO_HOST', 'localhost'),
    /*
    |--------------------------------------------------------------------------
    | Bitgo Express Server Port
    |--------------------------------------------------------------------------
    |
    | Please provide your Bitgo-Express server Port if other than :80
    |
     */
    'port' => env('BITGO_PORT'),
    /*
    |--------------------------------------------------------------------------
    | Bitgo Express (HTTP or HTTPs)
    |--------------------------------------------------------------------------
    |
    | If the express server is running on HTTPS, This should be set
    | to true -- otherwise, this will default to false and then,
    | http protocol will be used to access the express server.
    |
     */
    'secure' => env('BITGO_SECURE', false),
];
