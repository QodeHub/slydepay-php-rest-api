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

use GuzzleHttp\Psr7\Response;
use Qodehub\Bitgo\Api\Api;
use Qodehub\Bitgo\Utility\CanCleanParameters;
use Qodehub\Bitgo\Utility\MassAssignable;
use Qodehub\Bitgo\Wallet\ExecutionTrait;

/**
 * SendCoins Class
 *
 * This will be the base for all wallet related transaction
 *
 * This class will require that a walletId is present. Examples are attaches
 *
 * @example                               Transactions::wallet('waletId')->get();
 * @example                               Transactions::wallet('waletId')->get('waletId');
 * @example                               Transactions::wallet('waletId')->skip(10)->limit(10)->minConfirms(10)->compact()->get();
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class SendCoins extends Api implements ExecutionInterface
{
    use ExecutionTrait;
    use MassAssignable;
    use CanCleanParameters;
    use SendCoinsAccessors;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'address',
        'amount',
        'walletPassphrase',
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'fee',
        'message',
        'feeRate',
        'feeTxConfirmTarget',
        'maxFeeRate',
        'minUnspentSize',
        'minConfirms',
        'enforceMinConfirmsForChange',
        'sequenceId',
        'instant',
        'forceChangeAtEnd',
        'noSplitChange',
        'targetWalletUnspents',
        'validate',
        'feeSingleKeySourceAddress',
        'feeSingleKeyWIF',
        'otp',
    ];
    /**
     * Destination bitcoin address
     *
     * @var string
     */
    protected $address;
    /**
     * Amount to be sent (in Satoshis),
     * e.g. 0.1 * 1e8 for a tenth of a Bitcoin
     *
     * @var integer
     */
    protected $amount;
    /**
     * Passphrase for the wallet, used to decrypt
     * the encrypted user key (on client)
     *
     * @var string
     */
    protected $walletPassphrase;
    /**
     * The absolute fee in satoshis to be paid to the
     * Bitcoin miners. HIGHLY recommended to leave
     * undefined and use ‘feeTxConfirmTarget’
     * instead for dynamic fee estimates.
     *
     * @var integer
     */
    protected $fee;
    /**
     * User-provided string (this does not hit the blockchain)
     *
     * @var string
     */
    protected $message;
    /**
     * The fee in satoshis /per kB/ of transaction size to be
     * paid to the Bitcoin miners. HIGHLY recommended to
     * leave undefined and use ‘feeTxConfirmTarget’
     * instead for dynamic fee estimates.
     *
     * @var integer
     */
    protected $feeRate;
    /**
     * Calculate fees per kilobyte, targeting transaction
     * confirmation in this number of blocks.
     * Default: 2, Minimum: 1, Maximum: 1000.
     *
     * @var number
     */
    protected $feeTxConfirmTarget;
    /**
     * An upper bound for the fee rate in satoshi per kB.
     * Useful to set as a safety measure
     * when using dynamic fees.
     *
     * @var integer
     */
    protected $maxFeeRate;
    /**
     * Minimum amount in satoshis for an unspent to be
     * considered usable.
     * Defaults to 5460 (to combat tx dust spam).
     *
     * @var integer
     */
    protected $minUnspentSize;
    /**
     * only choose unspent inputs with a certain number
     * of confirmations. We recommend setting this to 1
     * and using enforceMinConfirmsForChange.
     *
     * @var integer
     */
    protected $minConfirms;
    /**
     * Defaults to false. When constructing a transaction,
     * minConfirms will only be enforced for unspents
     * not originating from the wallet.
     *
     * @var                                  boolean
     * @SuppressWarnings(PHPMD.LongVariable)
     */
    protected $enforceMinConfirmsForChange;
    /**
     * A custom user-provided string that can be used to
     * uniquely identify the state of this transaction
     * before and after signing
     *
     * @var string
     */
    protected $sequenceId;
    /**
     * A custom user-provided string that can be used to
     * uniquely identify the state of this transaction
     * before and after signing
     *
     * @var boolean
     */
    protected $instant;
    /**
     * Forces the change address to be the last output.
     *
     * @var boolean
     */
    protected $forceChangeAtEnd;
    /**
     * Specifies the change address instead of creating a new one.
     *
     * @var string
     */
    protected $changeAddress;
    /**
     * Set to true to disable automatic change splitting
     * for purposes of unspent management.
     *
     * @var boolean
     */
    protected $noSplitChange;
    /**
     * Specify a number of target unspents to maintain in the wallet.
     *
     * @var integer
     */
    protected $targetWalletUnspents;
    /**
     * Extra verification of the change addresses, which is
     * always done server-side and is redundant
     * client-side (defaults to true).
     *
     * @var boolean
     */
    protected $validate;
    /**
     * Use this single key address to pay fees
     *
     * @var string
     */
    protected $feeSingleKeySourceAddress;
    /**
     * Use the address based on this private key to pay fees
     *
     * @var string
     */
    protected $feeSingleKeyWIF;
    /**
     * A 7 digit code used to bypass a policy with the “getOTP” action type.
     *
     * @var string
     * @see https://bitgo.github.io/bitgo-docs/?shell#wallet-policy
     */
    protected $otp;
    /**
     * Construct for creating a new instance of this class
     *
     * @param array $data An array with assignable Parameters
     */
    public function __construct($data = [])
    {
        $this->massAssign($data);
    }

    /**
     * This will be the address that the coins will be sent to
     *
     * @param  string $address Address to send coins to
     * @return self
     */
    public function address($address)
    {
        return $this->setAddress($address);
    }

    /**
     * The method places the call to the Bitgo API
     *
     * @return Response
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_get('/wallet/' . $this->getWalletId() . '/tx/' . $this->getTransactionId(), $this->propertiesToArray());
    }
}
