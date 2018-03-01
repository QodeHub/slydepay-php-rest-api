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

namespace Qodehub\Bitgo\Api;

use Qodehub\Bitgo\Api\WalletAccessors;

/**
 * Api/Wallet Class
 *
 * This will be the base for all wallet related transaction
 */
class Wallet implements WalletInterface
{
    use WalletAccessors;

    /**
     * Admin rights on a walet
     * @var Object
     */
    protected $admin;
    /**
     * The wallet ID
     * @var string
     */
    protected $id;
    /**
     * The walet status. shows if the walet is active or not
     * @var boolean
     */
    protected $isActive;
    /**
     * A label of the wallet
     * @var string
     */
    protected $label;
    /**
     * The list of permissions on this wallet.
     * @var array
     */
    protected $permissions;
    /**
     * This private property will hold the set of keychains
     * returned from the bitgo API server
     * @var array
     */
    protected $private;
    /**
     * This is a boolean that shows if this wallet can
     * be used for spending
     * @var boolean
     */
    protected $spendingAccount;
    /**
     * This is the type of the walet. (i.e. SafeID)
     * @var tring
     */
    protected $type;
    /**
     * This is the url for this specific wallet.
     * @var string
     */
    protected $url;
    /**
     * This holds the number of approvals required to approve
     * pending approvals involving this wallet
     * @var boolean
     */
    protected $approvalsRequired;
    /**
     * This is the total balance on this wallet.
     * Including unconfirmed
     * @var float
     */
    protected $balance;
    /**
     * This is the confirmed balance on this wallet.
     * @var float
     */
    protected $confirmedBalance;
    /**
     * This is the total spendable balance on this wallet.
     * @var float
     */
    protected $spendableBalance;
}
