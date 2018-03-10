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
 * CreateAddress Class
 *
 * This class is responsible for creating addresses
 * on a wallet.
 *
 * @example Wallet::createAddress()
 *
 * Wallet::createWallet()
 * Wallet::create()
 * Wallet::address()->create()
 * Wallet::createAddress()
 * Address::create()->walletId($walletId)->run()
 * Address::create()->wallet($walletId)->run()
 */
class CreateAddress extends Wallet implements WalletInterface
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
        'label',
        'allowMigrated',
        'chain',
        'gasPrice',
        'label',
    ];

    /**
     * Specifies the address format, defaults to 0,
     * use 10 for SegWit (only on BTC and BTG)
     *
     * @var integer
     */
    protected $chain;

    /**
     * No  Set to true to enable address creation for migrated BCH wallets.
     *
     * @var boolean
     */
    protected $allowMigrated;

    /**
     * Custom gas price to be used for deployment of receive addresses (only for Ethereum)
     *
     * @var integer
     */
    protected $gasPrice;

    /**
     * Human-readable name for the address
     *
     * @var string
     */
    protected $label;

    /**
     * Construct for creating a new instance of this class
     *
     * @param array $data An array with assignable Parameters
     */
    public function __construct($data = [])
    {
        if (is_string($data)) {
            $this->address = $data;
        }

        if (is_array($data)) {
            $this->massAssign($data);
        }

        return $this;
    }

    /**
     * @return number
     */
    public function getChain()
    {
        return $this->chain;
    }

    /**
     * @param number $chain
     *
     * @return self
     */
    public function setChain($chain)
    {
        $this->chain = $chain;

        return $this;
    }

    /**
     * Set the chain type
     *
     * @param  number $chain (0, 1, 10 or 11 (10 or 11 for SegWit))
     * @return self
     */
    public function chain($chain)
    {
        return $this->setChain($chain);
    }

    /**
     * Set the value of the allow migrated
     *
     * @param  boolean $allowMigrated
     * @return self
     */
    public function allowMigrated($allowMigrated)
    {
        return $this->setAllowMigrated($allowMigrated);
    }

    /**
     * Set the value of the Gas Price
     *
     * @param  integer $gasPrice
     * @return self
     */
    public function gasPrice($gasPrice)
    {
        return $this->setGasPrice($gasPrice);
    }

    /**
     * Set the value of the label
     *
     * @param  string $label
     * @return self
     */
    public function label($label)
    {
        return $this->setLabel($label);
    }

    /**
     * @return boolean
     */
    public function getAllowMigrated()
    {
        return $this->allowMigrated;
    }

    /**
     * @param boolean $allowMigrated
     *
     * @return self
     */
    public function setAllowMigrated($allowMigrated)
    {
        $this->allowMigrated = $allowMigrated;

        return $this;
    }

    /**
     * @return integer
     */
    public function getGasPrice()
    {
        return $this->gasPrice;
    }

    /**
     * @param integer $gasPrice
     *
     * @return self
     */
    public function setGasPrice($gasPrice)
    {
        $this->gasPrice = $gasPrice;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * This will call the api and create the wallet after all parameters
     * have been set.
     *
     * @return Response  A response from the bitgo server
     */
    public function run()
    {

        $this->propertiesPassRequired();

        return $this->_post(
            '/wallet/{walletId}/address',
            $this->propertiesToArray()
        );
    }
}
