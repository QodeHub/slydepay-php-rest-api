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

/**
 * Addresses Class
 *
 * This will be the base for all wallet related transaction
 *
 * This class will require that a walletId is present. Examples are attaches
 *
 * @example Addresses::btc('waletId')->get();
 * @example Btc::wallet('waletId')->addresses($optional-address-id)->config($config)->get();
 * @example Bitgo::btc($config)->wallet('waletId')->addresses($optional-address-id)->get();
 * @example Transactions::wallet('waletId')->skip(10)->limit(10)->minConfirms(10)->compact()->get();
 */
class Addresses extends Api implements ExecutionInterface
{
    use ExecutionTrait;
    use MassAssignable;
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
        'chain',
        'skip',
        'limit',
        'details',
    ];

    /**
     * Optionally restrict to chain 0, 1, 10 or 11
     *
     * @var number
     */
    protected $chain;
    /**
     *     Skip this number of results
     *
     * @var number
     */
    protected $skip;
    /**
     * Limit number of results to this number (default=25, max=500)
     *
     * @var number
     */
    protected $limit;
    /**
     * Include details like balance and transaction count info
     *
     * @var boolean
     */
    protected $details;
    /**
     * Get for a single address
     *
     * @var boolean
     */
    protected $address;

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
     * @param boolean $chain
     *
     * @return self
     */
    public function chain($chain)
    {
        return $this->setChain($chain);
    }

    /**
     * @param boolean $details
     *
     * @return self
     */
    public function details($details)
    {
        return $this->setDetails($details);
    }

    /**
     * @return mixed
     */
    public function getChain()
    {
        return $this->chain;
    }

    /**
     * @param mixed $chain
     *
     * @return self
     */
    public function setChain($chain)
    {
        $this->chain = $chain;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSkip()
    {
        return $this->skip;
    }

    /**
     * @param mixed $skip
     *
     * @return self
     */
    public function setSkip($skip)
    {
        $this->skip = $skip;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param mixed $limit
     *
     * @return self
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     *
     * @return self
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * The method places the call to the Bitgo API
     *
     * @param  string|null $address get data for a single address
     * @return Object
     */
    public function run($address = null)
    {
        $this->setAddress($address);

        $this->propertiesPassRequired();

        return $this->_get(
            '/wallet/' . $this->getWalletId() . '/addresses/' . $this->getAddress(),
            $this->propertiesToArray()
        );
    }
}
