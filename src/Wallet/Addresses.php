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
use Qodehub\Bitgo\Coin;
use Qodehub\Bitgo\Utility\CanCleanParameters;
use Qodehub\Bitgo\Utility\MassAssignable;
use Qodehub\Bitgo\Wallet;

/**
 * Addresses Class
 *
 * This will be the base for all wallet related transaction
 *
 * This class requires that a walletId be present. Examples are attaches
 *
 * @example Btc::btc($config)->wallet($waletId)->addresses()->get();
 * @example Btc::btc($config)->wallet($waletId)->addresses($address)->get();
 * @example Btc::btc($config)->wallet($waletId)->addresses($addressId)->get();
 */
class Addresses extends Api
{
    use WalletTrait;
    use MassAssignable;
    use CanCleanParameters;
    use Coin;
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
        'address',
    ];

    /**
     * Get for a single address. This could be an address or and addressID
     *
     * @var string
     */
    protected $address;

    /**
     * Construct for creating a new instance of this class
     *
     * @param array|string $data An array with assignable Parameters or an
     *                           Address or an addressID
     */
    public function __construct($data = null)
    {

        if (is_string($data)) {
            $this->setAddress($data);
        }

        if (is_array($data)) {
            $this->massAssign($data);
        }
    }

    /**
     * Find a single address adminst all the addresses
     * from the server.
     *
     * @param  string $address This will be an existing
     *                         address or addressId
     * @return self
     */
    public function find($address)
    {
        return $this->address($address);
    }

    /**
     * This will allow chaining the address to the insance
     *
     * @param string $address This is an address or an addressID
     *
     * @return self
     */
    public function address($address)
    {
        $this->setAddress($address);

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
     * @return Object
     */
    public function run()
    {
        $this->propertiesPassRequired();

        return $this->_get(
            '/wallet/{walletId}' . ($this->getAddress() ? '/address/{address}' : '/addresses'),
            $this->propertiesToArray()
        );
    }
}
