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

use Qodehub\Bitgo\Api\Api;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\Wallet as WalletImplementation;

/**
 * Api/Wallet Class
 *
 * This will be the base for all wallet related transaction
 */
abstract class Wallet extends WalletImplementation implements WalletInterface
{
    /**
     * This function will place a magic call to the create
     * address class, giving all available methods on
     * for chaining.
     *
     * @param  array|null $attributes This will accept an
     *                                array of arguements for
     *                                configuration.
     * @return CreateAddress
     */
    abstract public function createAddress($attributes = []);

    /**
     * This function will place a magic call to the SendCoins
     * class, giving all available methods on for chaining.
     *
     * @param  array|null $attributes This will accept an
     *                                array of arguements
     *                                for configuration.
     * @return SendCoins
     */
    abstract public function sendCoins($attributes = []);

    /**
     * This function will place a magic call to the Create
     * class, giving all available methods on for chaining.
     *
     * @param  array|null $attributes This will accept an
     *                                array of arguements
     *                                for configuration.
     * @return Create
     */
    abstract public function create($attributes = []);

    /**
     * This function will place a magic call to the Addresses
     * class, giving all available methods on for chaining.
     *
     * @param  array|null $attributes This will accept an
     *                                array of arguements
     *                                for configuration.
     * @return Addresses
     */
    abstract public function addresses($attributes = []);

    /**
     * This function will place a magic call to the CreateWallet
     * class, giving all available methods on for chaining.
     *
     * @param  array|null $attributes This will accept an
     *                                array of arguements
     *                                for configuration.
     * @return CreateWallet
     */
    abstract public function createWallet($attributes = []);
}
