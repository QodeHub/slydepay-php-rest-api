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

use Qodehub\Bitgo\Api\ApiInterface;

/**
 * WalletInterface Interface
 *
 * This will be the base for all wallet related transaction
 */
interface WalletInterface extends ApiInterface
{

    /**
     * When this class is accessed as a method directly
     * from a wallet instance, the wallet instance
     * will pass in the wallet ID by calling
     * this mathod using magic methods.
     *
     * You can also modify the wallet on the instance
     * by pasing in the wallet ID or instance
     *
     * @param Qodehub\Bitgo\Wallet|string $walletId This is the wallet id.
     *
     * @return self                                      This will be the instance
     *                                                   of the class it is
     *                                                   called from.
     */
    public function wallet($walletId);
}
