<?php
/**
 * FIX
 */
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
use Qodehub\Bitgo\Wallet\ExecutionInterface;
use Qodehub\Bitgo\Wallet\ExecutionTrait;

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
 *
 * @SuppressWarnings(PHPMD.ShortVariable)
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class CreateWallet extends Api implements ExecutionInterface
{
    use ExecutionTrait;
    use MassAssignable;
    use CanCleanParameters;
    use Keychains;

    /**
     * {@inheritdoc}
     */
    protected $parametersRequired = [
        'label',
        'm',
        'n',
        'keychains',
    ];

    /**
     * {@inheritdoc}
     */
    protected $parametersOptional = [
        'enterprise',
        'disableTransactionNotifications',
    ];

    /**
     * A label for this wallet
     *
     * @var string
     */
    protected $label;
    /**
     * The number of signatures required to redeem (must be 2)
     *
     * @var integer
     */
    protected $m = 2;
    /**
     * The number of keys in the wallet (must be 3)
     *
     * @var integer
     */
    protected $n = 3;
    /**
     * An array of n keychain xpubs to use with this wallet;
     * last must be a BitGo key
     *
     * @var Keychains
     */
    protected $keychains;
    /**
     * Enterprise ID to create this wallet under.
     *
     * @var string
     */
    protected $enterprise;
    /**
     * Set to true to prevent wallet transaction notifications
     *
     * @var boolean
     */
    protected $disableTransactionNotifications;

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
     * Set the keychains for the bitgo network
     *
     * @param  Keychains $keychains This is a keychains instance
     *                              containing with all three
     *                              keys configured
     *                              ([XPUB_USER, XPUB_BACKUP, XPUB_BACKUP])
     * @return self
     */
    public function keychains(Keychains $keychains)
    {
        return $this->setKeychains($keychains);
    }

    /**
     * This will set the label of the wallet.
     *
     * @param  string $label This is the label for the wallet
     * @return self
     */
    public function label($label)
    {
        return $this->setLabel($label);
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
     * @return Keychains
     */
    public function getKeychains()
    {
        return $this->keychains;
    }

    /**
     * @param Keychains $keychains
     *
     * @return self
     */
    public function setKeychains(Keychains $keychains)
    {
        $this->keychains = $keychains;

        return $this;
    }

    /**
     * @return string
     */
    public function getEnterprise()
    {
        return $this->enterprise;
    }

    /**
     * @param string $enterprise
     *
     * @return self
     */
    public function setEnterprise($enterprise)
    {
        $this->enterprise = $enterprise;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getDisableTransactionNotifications()
    {
        return $this->disableTransactionNotifications;
    }

    /**
     * @param boolean $disableTransactionNotifications
     *
     * @return self
     */
    public function setDisableTransactionNotifications($disableTransactionNotifications)
    {
        $this->disableTransactionNotifications = $disableTransactionNotifications;

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

        return $this->_post('/wallet/' . $this->getWalletId() . '/address/' . $this->getChain());
    }
}
