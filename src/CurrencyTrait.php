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

/**
 * CurrencyTrait Trait
 *
 * This trait initializes the currency namespace
 * on any class that uses it.
 *
 * @see \Qodehub\Bitgo\Wallet\ExecutionInterface
 */
trait CurrencyTrait
{
    /**
     * This is the coin type.
     *
     * @var string
     */
    protected $coin;

    /**
     * [$coin description]
     * @var [type]
     */
    protected $isCoinPath = true;

    /**
     * It's as it sounds. These are possible
     * coins that can be be used with this plugin.
     *
     * @var array
     */
    private $posibleCoins = [
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

    /**
     * @return string
     */
    public function getCoin()
    {
        return $this->coin;
    }

    /**
     * @param string $coin
     *
     * @return self
     */
    public function setCoin($coin)
    {
        $this->coin = $coin;

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
        if (in_array(str_tolower($method), $this->possibleCoins)) {

            /**
             * If the class name is among possible coins,
             * create a new instance of the class using
             * this trait and set the coins to static
             * coin name.
             */

            return (new self(...$parameters))->coin($method);
        }

        /**
         * Check for bridge classes
         */
        if (in_array($method, ['wallet', 'createWallet'])) {

            /**
             * Pass the call on to an instnace of the implementing class
             * if the static method name is one of the above methods.
             */

            return (new self)->{$method}(...$parameters);
        }

        throw new \BadStaticCallException('Undefined method [ ' . $method . '] called.');
    }
}
