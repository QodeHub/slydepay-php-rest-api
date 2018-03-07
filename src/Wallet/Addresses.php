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

use Qodehub\Bitgo\Coin;
use Qodehub\Bitgo\Utility\CanCleanParameters;
use Qodehub\Bitgo\Utility\MassAssignable;
use Qodehub\Bitgo\Wallet;

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
class Addresses extends Wallet implements WalletInterface
{
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
            $this->address = $data;
        }

        if (is_array($data)) {
            $this->massAssign($data);
        }
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
        $this->address = $address;

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
        $this->urlPattern = '';

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
