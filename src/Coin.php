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

namespace Qodehub\Bitgo;

use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\ConfigInterface;

/**
 * CoinTrait Trait
 *
 * This trait initializes the currency namespace
 * on any class that uses it.
 *
 * @see \Qodehub\Bitgo\Wallet\ExecutionInterface
 */
trait Coin
{
    /**
     * This is the coin type.
     *
     * @var string
     */
    protected $coinType;

    /**
     * This is the ID of the wallet that the
     * API will interact with. It is also the
     * first wallet receiving address.
     *
     * @var string
     */
    protected $walletId;

    /**
     * Just as it sounds -- these are possible
     * coins that can be be used with this plugin.
     *
     * @return array an array of possible coins
     */
    protected static function possibleCoinTypes()
    {
        return [
            'btc',
            'bch',
            'btg',
            'eth',
            'ltc',
            'rmg',
            'erc',
            'omg',
            'zrx',
            'fun',
            'gnt',
            'rep',
            'bat',
            'knc',
            'cvc',
            'eos',
            'qrl',
            'nmr',
            'pay',
            'brd',
            'tbtc',
            'tbch',
            'teth',
            'tltc',
            'txrp',
            'trmg',
            'terc',
        ];
    }

    /**
     * This will set the coin type on the class instance
     *
     * @param  string $coinType The wallet ID should be passed in here
     * @return Qodehub\Bitgo\Wallet|string           The wallet ID or Instance
     *
     * @see \Qodehub\Bitgo\Wallet\ExecutionInterface
     */
    public function coinType($coinType)
    {
        return $this->setCoinType($coinType);
    }

    /**
     * @return string
     */
    public function getCoinType()
    {
        return $this->coinType;
    }

    /**
     * @param string $coinType
     *
     * @return self
     */
    public function setCoinType($coinType)
    {
        $this->coinType = $coinType;

        return $this;
    }

    /**
     * Dynamically set the coin type and the configuration
     * that was passed in.
     *
     * @param  string $method
     * @param  Config $parameters
     * @return self
     * @throws \BadMethodCallException
     *
     * @example Transactions::btc($config)->wallets($walletId)->get();
     * @example Addresses::ltc($config)->wallets($walletId)->get();
     * @example Wallets::eth($config)->wallets($walletId)->get();
     */
    public static function __callStatic($method, $parameters)
    {
        /**
         * Restrict the static class names.
         */
        if (in_array(strtolower($method), self::possibleCoinTypes())) {
            return self::initializeWithCoinName($method, $parameters);
        }

        /**
         * Check for bridge classes
         */
        if (in_array($method, ['wallet', 'createWallet'])) {

            /**
             * Pass the call on to an instnace of the implementing class
             * if the static method name is one of the above methods.
             */

            return (new self)->$method(...$parameters);
        }

        throw new \Error('Call to undefined method ' . static::class . '::' . $method);
    }

    /**
     * This will initialize the class with the static coin method name
     *
     * @param  string $method     The method name.
     * @param  any    $parameters The remianing parameters passed into the coin.
     * @return self
     */
    private static function initializeWithCoinName($method, $parameters)
    {

        /**
         * create a new instance of the class using
         * and set the coins to static coin name
         * that was passed in earlier.
         */

        $instance = (new self)->coinType($method);

        /**
         * Inject the Api configuration if is the
         * first arguement that was passed into
         */
        if (array_key_exists(0, $parameters) && $parameters[0] instanceof ConfigInterface) {
            $instance->setConfig($parameters[0]);
        }

        return $instance;
    }
}
