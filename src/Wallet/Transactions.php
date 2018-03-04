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
use Qodehub\Bitgo\Utility\CanCleanParameters;
use Qodehub\Bitgo\Utility\MassAssignable;
use Qodehub\Bitgo\Wallet\ExecutionTrait;
use Qodehub\Bitgo\Wallet\TransactionsAccessors;

/**
 * Transactions Class
 *
 * This will be the base for all wallet related transaction
 *
 * This class will require that a walletId is present. Examples are attaches
 *
 * @example Transactions::wallet('waletId')->get();
 * @example Transactions::wallet('waletId')->get('waletId');
 * @example Transactions::wallet('waletId')->skip(10)->limit(10)->minConfirms(10)->compact()->get();
 */
class Transactions extends Api implements ExecutionInterface
{
    use ExecutionTrait;
    use MassAssignable;
    use TransactionsAccessors;
    use CanCleanParameters;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'walletId',
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'skip',
        'limit',
        'compact',
        'minHeight',
        'maxHeight',
        'minConfirms',
    ];

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
     * The starting index number to list from. Default is 0.
     *
     * @var boolean
     */
    protected $skip;
    /**
     * Max number of results to return in a single call (default=25, max=250)
     *
     * @var number
     */
    protected $limit;
    /**
     * Omit inputs and outputs in the transaction results
     *
     * @var boolean
     */
    protected $compact;
    /**
     * A lower limit of blockchain height at which the transaction
     * was confirmed. Does not filter unconfirmed transactions.
     *
     * @var number
     */
    protected $minHeight;
    /**
     * An upper limit of blockchain height at which the transaction was confirmed.
     *
     * @var number
     */
    protected $maxHeight;
    /**
     * Only shows transactions with at least this many confirmations,
     * filters transactions that have fewer confirmations.
     *
     * @var number
     */
    protected $minConfirms;

    /**
     * @param boolean $skip
     *
     * @return self
     */
    public function skip($skip)
    {
        return $this->setSkip($skip);
    }

    /**
     * @param number $limit
     *
     * @return self
     */
    public function limit($limit)
    {
        return $this->setLimit($limit);
    }

    /**
     * @param boolean $compact
     *
     * @return self
     */
    public function compact($compact)
    {
        return $this->setCompact($compact);
    }

    /**
     * @param number $minHeight
     *
     * @return self
     */
    public function minHeight($minHeight)
    {
        return $this->setMinHeight($minHeight);
    }

    /**
     * @param number $maxHeight
     *
     * @return self
     */
    public function maxHeight($maxHeight)
    {
        return $this->setMaxHeight($maxHeight);
    }

    /**
     * @param number $minConfirms
     *
     * @return self
     */
    public function minConfirms($minConfirms)
    {
        return $this->setMinConfirms($minConfirms);
    }

    /**
     * The method places the call to the Bitgo API
     * @param number|null $transactionId Id for a single transaciton resources
     * @return Object
     */
    public function run($transactionId = null)
    {
        $this->propertiesPassRequired();

        return $this->_get('/wallet/' . $this->getWalletId() . '/tx/' . $transactionId, $this->propertiesToArray());
    }
}
