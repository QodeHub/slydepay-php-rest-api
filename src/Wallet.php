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
 * Api/Wallet Class
 *
 * This will be the base for all wallet related transaction
 */
class Wallet extends Api implements WalletInterface
{
    use WalletAccessors;

    /**
     * Admin rights on a walet
     *
     * @var Object
     */
    protected $admin;
    /**
     * The wallet ID
     *
     * @var string
     */
    protected $id;
    /**
     * The walet status. shows if the walet is active or not
     *
     * @var boolean
     */
    protected $isActive;
    /**
     * A label of the wallet
     *
     * @var string
     */
    protected $label;
    /**
     * The list of permissions on this wallet.
     *
     * @var array
     */
    protected $permissions;
    /**
     * This private property will hold the set of keychains
     * returned from the bitgo API server
     *
     * @var array
     */
    protected $private;
    /**
     * This is a boolean that shows if this wallet can
     * be used for spending
     *
     * @var boolean
     */
    protected $spendingAccount;
    /**
     * This is the type of the walet. (i.e. SafeID)
     *
     * @var tring
     */
    protected $type;
    /**
     * This is the url for this specific wallet.
     *
     * @var string
     */
    protected $url;
    /**
     * This holds the number of approvals required to approve
     * pending approvals involving this wallet
     *
     * @var boolean
     */
    protected $approvalsRequired;
    /**
     * This is the total balance on this wallet.
     * Including unconfirmed
     *
     * @var float
     */
    protected $balance;
    /**
     * This is the confirmed balance on this wallet.
     *
     * @var float
     */
    protected $confirmedBalance;
    /**
     * This is the total spendable balance on this wallet.
     *
     * @var float
     */
    protected $spendableBalance;
    /**
     * The construct method accepts a the ID of the wallet that it will be interracting with.
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
        if (in_array($method, ['transactions', 'addresses', 'sendCoins', 'createAddress'])) {

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
