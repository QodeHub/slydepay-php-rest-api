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
use Qodehub\Bitgo\Coin;
use Qodehub\Bitgo\Utility\CanCleanParameters;
use Qodehub\Bitgo\Utility\MassAssignable;
use Qodehub\Bitgo\Wallet;

/**
 * SendCoins Class
 *
 * This class implements methods for sending money from a wallet to an address
 *
 * This class will require that a walletId is present. Examples are attaches
 *
 * @example Bitgo::btc($config)->wallet($walletId)->send($amout)->to($address)->passphrase($passphrase)->run();
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class SendCoins extends Wallet implements WalletInterface
{
    use MassAssignable;
    use CanCleanParameters;
    use SendCoinsAccessors;
    use Coin;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'walletId',
        'address',
        'amount',
        'walletPassphrase',
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'prv',
        'numBlocks',
        'feeRate',
        'comment',
        'minConfirms',
        'enforceMinConfirmsForChange',
        'targetWalletUnspents',
        'noSplitChange',
        'minValue',
        'maxValue',
        'gasPrice',
        'gasLimit',
        'sequenceId',
        'segwit',
        'lastLedgerSequence',
        'ledgerSequenceDelta',
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
     * Any additional comment to attach to the transaction
     *
     * @var string
     */
    protected $comment;
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
     * Set to true to disable automatic change splitting
     * for purposes of unspent management.
     *
     * @var boolean
     */
    protected $noSplitChange;
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
     * Minimum number of confirmations unspents
     * going into this transaction should have.
     *
     * @var integer
     */
    protected $minConfirms;
    /**
     * The private key in string form if the
     * walletPassphrase is not available
     *
     * @var string
     */
    protected $prv;
    /**
     * Estimates the approximate fee per kilobyte necessary
     * for a transaction confirmation within numBlocks blocks.
     *
     * @var integer
     */
    protected $numblocks;
    /**
     * The desired count of unspents in the wallet. If the wallet’s
     * current unspent count is lower than the target, up to
     * four additional change outputs will be added to the
     * transaction. To reduce unspent count in your
     * wallet see 'Consolidate Unspents’.
     *
     * @var integer
     */
    protected $targetWalletUnspents;
    /**
     * Ignore unspents smaller than this amount of satoshis
     *
     * @var integer
     */
    protected $minValue;
    /**
     * Ignore unspents larger than this amount of satoshis
     *
     * @var integer
     */
    protected $maxValue;
    /**
     * Custom gas limit for the transaction
     *
     * @var integer
     */
    protected $gasLimit;
    /**
     * Custom gas price to be used for sending the transaction
     * This only applies for ETH
     *
     * @var integer
     */
    protected $gasPrice;
    /**
     * The sequence ID of the transaction
     *
     * @var integer
     */
    protected $sequenceId;
    /**
     * Allow SegWit unspents to be used, and create SegWit change.
     *
     * @var integer
     */
    protected $segwit;
    /**
     * Absolute max ledger the transaction should be accepted in,
     * whereafter it will be rejected.
     *
     * @var integer
     */
    protected $lastLedgerSequence;
    /**
     * Relative ledger height (in relation to the current ledger)
     * that the transaction should be accepted in,
     * whereafter it will be rejected.
     *
     * @var integer
     */
    protected $ledgerSequenceDelta;

    /**
     * Construct for creating a new instance of this class
     *
     * @param array $data An array with assignable Parameters
     */
    public function __construct($data = [])
    {
        if (is_array($data)) {
            return $this->massAssign($data);
        }

        if (preg_match('/^(?:\d*\.)?\d+$/', $data)) {
            $this->setAmount($data);
        }
    }

    /**
     * This is the address that the coins will be sent
     * to. This method can be used interchangably with
     * receiver, to and address.
     *
     * @param  string $address this will be the receiving address
     * @return self
     *
     * @SuppressWarnings(PHPMD.ShortMethodName)
     */
    public function to($address)
    {
        return $this->receiver($address);
    }

    /**
     * This helper method wills et the comment on the
     * send coins instance.
     *
     * @param  string $comment this is the comment
     *                         for a transaction
     * @return self
     */
    public function comment($comment)
    {
        return $this->setComment($comment);
    }

    /**
     * This is the address that the coins will be sent
     * to. This method can be used interchangably with
     * receiver, to and address.
     *
     * @param  string $address this will be the receiving address
     * @return self
     */
    public function receiver($address)
    {
        return $this->address($address);
    }
    /**
     * This is the address that the coins will be sent
     * to. This method can be used interchangably with
     * receiver, to and address.
     *
     * @param  string $address this will be the receiving address
     * @return self
     */
    public function address($address)
    {
        return $this->setAddress($address);
    }
    /**
     * Use this chain method to define the amount of coins
     * that will be sent.
     *
     * @param  integer $amount This will be the amount will be sent.
     *                         In BTC for example this will be the
     *                         amount in satoshi.
     * @return self
     */
    public function amount($amount)
    {
        return $this->setAmount($amount);
    }

    /**
     * This will set the wallet passphrase and allow a chain method to
     * the run function.
     *
     * @param  string $walletPassphrase The passphrase for the wallet
     *                                  to send money from.
     * @return self
     */
    public function passphrase($walletPassphrase)
    {
        return $this->setWalletPassphrase($walletPassphrase);
    }

    /**
     * The method places the call to the Bitgo API
     *
     * @return Response
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_post(
            '/wallet/{walletId}/sendcoins',
            $this->propertiesToArray()
        );
    }
}
