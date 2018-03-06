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
use Qodehub\Bitgo\Wallet\WalletAccessors;
use Qodehub\Bitgo\Wallet\WalletInterface;

/**
 * Wallet Class
 *
 * This API call retrieves wallet object information by the wallet ID.
 * This is useful to get the balance of the wallet, or
 * identify the keys used to sign with the wallet
 * using the Get Keychain API.
 *
 * @example Transactions::wallet('waletId')->get();
 * @example Transactions::wallet('waletId')->get('waletId');
 * @example Transactions::wallet('waletId')->skip(10)->limit(10)->minConfirms(10)->compact()->get();
 */
class Wallet extends Api implements WalletInterface
{
    use WalletAccessors;

    /**
     * An object containing the policies set on the wallet
     *
     * @var Object
     */
    protected $admin;
    /**
     * ID of the wallet (also the first receiving address)
     *
     * @var string
     */
    protected $id;
    /**
     * A label of the wallet
     *
     * @var string
     */
    protected $label;
    /**
     * The digital currency this wallet holds
     *
     * @var string
     */
    protected $coin;
    /**
     * Array of key ids on the wallet, in the order of User, Backup and BitGo.
     *
     * @var array
     */
    protected $keys;
    /**
     * Enterprise ID if wallet belongs to an enterprise
     *
     * @var string
     */
    protected $enterprise;
    /**
     * Array of users and their permissions on the requested wallet
     *
     * @var string
     */
    protected $users;
    /**
     * Number of approvers needed to confirm transactions or
     * policy changes on the wallet
     *
     * @var boolean
     */
    protected $approvalsRequired;
    /**
     * The current amount of satoshi that is currently spendable.
     * (May not be set for some coins.)
     *
     * @var float
     */
    protected $balance;
    /**
     * The amount of satoshis you have within your wallet
     * in the form of confirmed unspents.
     * (May not be set for some coins.)
     *
     * @var float
     */
    protected $confirmedBalance;
    /**
     * The current amount of satoshi that is currently
     * spendable. (May not be set for some coins.)
     *
     * @var float
     */
    protected $spendableBalance;
    /**
     * True if the wallet initialization transaction(s)
     * is(are) still unconfirmed (valid for Ethereum)
     *
     * @var boolean
     */
    protected $pendingChainInitialization;
    /**
     * True if wallet is a cold wallet
     *
     * @var boolean
     */
    protected $isCold;
    /**
     * The construct method accepts a the ID of the wallet
     * that it will be interracting with.
     *
     * @param string $walletId the wallet id to interract with
     */
    public function __construct($walletId = null)
    {
        $this->setId($walletId);
    }
    /**
     * Dynamically handle missing Static Call to sub classes.
     *
     * @param   string $method
     * @param   array  $parameters
     * @return  self
     * @throws  \BadMethodCallException
     * @example Wallet::transactions()->get();
     * @example Wallet::transactions()->get('transactionId');
     */
    public static function __callStatic($method, array $parameters)
    {
        return (new self)->__call($method, $parameters);
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
    public function __call($method, array $parameters)
    {
        /**
         * Restrict the possible methods that can be called.
         *
         * @see \Qodehub\Bitgo::getApiInstance
         */
        if (in_array($method, ['transactions', 'transfers', 'addresses', 'create', 'sendCoins', 'createAddress', 'createWallet'])) {

            /**
             * Append a capitalized name of the method
             * passed in, to create a class address
             *
             * @var string
             */
            $class = '\\Qodehub\\Bitgo\\Wallet\\' . ucwords($method);

            /**
             * Check if the class exists
             */
            if (class_exists($class)) {
                /**
                 * Create a new instance of the class
                 * since it exists and is in the
                 * list of allowed magic
                 * methods lists.
                 */
                $executionInstace = new $class(...$parameters);

                /**
                 * Inject the wallet ID from the current
                 * wallet instance so that it is
                 * accessible in the class
                 * that will need it.
                 */
                $executionInstace->wallet($this->id);

                /**
                 * Inject the Api configuration if
                 * any exists on the chain.
                 */
                if ($this->config instanceof Config) {
                    $executionInstace->injectConfig($this->config);
                }

                return $executionInstace;
            }
        }

        throw new \BadMethodCallException('Undefined method [ ' . $method . '] called.');
    }
}
