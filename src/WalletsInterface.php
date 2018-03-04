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

namespace Qodehub\Bitgo\Wallet;

use Qodehub\Bitgo\ApiInterface;

/**
 * Api/Wallet Interface
 *
 * This will be the base for all wallet related transaction
 */
interface WalletInterface extends ApiInterface
{

    // public function createAddress();
    // Send Coins to Address
    // Send Coins to Multiple Addresses
    // list Wallet Transactions
    // Get Wallet Transaction
    // list Wallet Addresses
    // Get Single Wallet Address
}
