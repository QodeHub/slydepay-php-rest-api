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

use Qodehub\Bitgo\Api\Api;
use Qodehub\Bitgo\Config;
use Qodehub\Bitgo\Utility\CanCleanParameters;
use Qodehub\Bitgo\Utility\MassAssignable;
use Qodehub\Bitgo\Wallet\WalletAccessors;
use Qodehub\Bitgo\Wallet\WalletInterface;
use Qodehub\Bitgo\Wallet\WalletTrait;

/**
 * Wallet Class
 *
 * This API call retrieves wallet object information by the wallet ID.
 * This is useful to get the balance of the wallet, or
 * identify the keys used to sign with the wallet
 * using the Get Keychain API.
 *
 * @example Transactions::btc($config)->wallet('waletId')->get();
 * @example Transactions::btc($config)->wallet('waletId')->get('waletId');
 * @example Transactions::btc($config)->wallet('waletId')->skip(10)->limit(10)->minConfirms(10)->compact()->get();
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Wallet extends Api implements WalletInterface
{
    use WalletAccessors;
    use WalletTrait;
    use CanCleanParameters;
    use MassAssignable;
    use Coin;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'walletId',
        'allTokens',
        'prevId',
        'limit',
    ];

    /**
     * Max number of results in a single call. Defaults to 25.
     *
     * @var integer
     */
    protected $limit;
    /**
     * Gets details of all tokens associated with
     * this wallet. Only valid for eth/teth
     *
     * @var string
     */
    protected $allTokens;
    /**
     * Continue iterating wallets from this prevId as
     * provided by nextBatchPrevId in the previous list
     *
     * @var string
     */
    protected $prevId;

    /**
     * The construct method accepts a the ID of the wallet
     * that it will be interracting with.
     *
     * @param string $walletId the wallet id to interract with
     */
    public function __construct($walletId = null)
    {
        $this->wallet($walletId);
    }

    /**
     * {@inheritdoc}
     */
    public function createAddress($attributes = [])
    {
        return $this->getWalletInstance('CreateAddress', $attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function sendCoins($attributes = [])
    {
        return $this->getWalletInstance('SendCoins', $attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function create($attributes = [])
    {
        return $this->getWalletInstance('CreateWallet', $attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function addresses($attributes = [])
    {
        return $this->getWalletInstance('Addresses', $attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function transactions($attributes = [])
    {
        return $this->getWalletInstance('Transactions', $attributes);
    }

    /**
     * {@inheritdoc}
     */
    public function createWallet($attributes = [])
    {
        return $this->getWalletInstance('CreateWallet', $attributes);
    }

    /**
     * This will set the ID of the wallet that you want to get.
     * for a single wallet.
     *
     * @param  string $walletId Wallet ID
     * @return self
     */
    public function find($walletId)
    {
        return $this->setWalletId($walletId);
    }

    /**
     * The method places the call to the Bitgo API
     *
     * @return Response
     */
    public function run()
    {
        return $this->_get('/wallet/{walletId}', $this->propertiesToArray());
    }

    /**
     * Dynamically handle calls to sub-classes and pass in the wallet instance ID.
     *
     * @param   string $method
     * @param   array  $parameters
     * @return  self
     * @throws  \BadMethodCallException
     * @example walletInstance->transactions()->get();
     * @example walletInstance->transactions()->get('transactionId');
     */
    protected function getWalletInstance($method, $parameters)
    {

        /**
         * Append a capitalized name of the method
         * passed in, to create a class address
         *
         * @var string
         */
        $class = '\\Qodehub\\Bitgo\\Wallet\\' . ucwords($method);

        /**
         * Create a new instance of the class
         * since it exists and is in the
         * list of allowed magic
         * methods lists.
         */
        $executionInstace = new $class($parameters);

        /**
         * Inject the wallet ID from the current
         * wallet instance so that it is
         * accessible in the class
         * that will need it.
         */
        $executionInstace->wallet($this->getWalletId());

        /**
         * Inject the coin type
         */
        $executionInstace->coinType($this->getCoinType());

        /**
         * Inject the Api configuration if
         * any exists on the chain.
         */
        if ($this->getConfig() instanceof Config) {
            $executionInstace->injectConfig($this->getConfig());
        }

        return $executionInstace;
    }
}
